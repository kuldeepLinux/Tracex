// TraceX - Dashboard Logic

// Live Time
function updateTime() {
    const now = new Date();
    document.getElementById('liveTime').textContent = now.toLocaleTimeString('en-IN');
}
setInterval(updateTime, 1000);
updateTime();

// World Map Initialize
const map = L.map('worldMap', {
    zoomControl: false,
    attributionControl: false
}).setView([20, 0], 2);

// Dark tile layer
L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    maxZoom: 19
}).addTo(map);

// Track markers
let markers = [];

// Fetch Data
async function fetchData() {
    try {
        const res = await fetch('get_logs.php');
        const data = await res.json();
        
        updateStats(data.stats);
        updateLogs(data.recent);
        updateMap(data.logs);
    } catch (err) {
        console.log('Fetch error:', err);
    }
}

function updateStats(stats) {
    animateValue('totalVisits', stats.totalVisits);
    animateValue('uniqueIPs', stats.uniqueIPs);
    animateValue('countries', stats.countries);
    animateValue('isps', stats.isps);
}

function animateValue(id, value) {
    const el = document.getElementById(id);
    const current = parseInt(el.textContent) || 0;
    const diff = value - current;
    const steps = 20;
    let step = 0;
    
    const interval = setInterval(() => {
        step++;
        el.textContent = Math.round(current + (diff * step / steps));
        if (step >= steps) {
            el.textContent = value;
            clearInterval(interval);
        }
    }, 30);
}

function updateLogs(logs) {
    const list = document.getElementById('logsList');
    
    if (!logs || logs.length === 0) {
        list.innerHTML = '<p class="empty-msg">Koi activity nahi. Link share karein.</p>';
        return;
    }
    
    list.innerHTML = logs.map((log, i) => `
        <div class="log-item">
            <span class="log-number">#${i + 1}</span>
            <span class="log-ip">${log.ip}</span>
            <span class="log-country">${log.country}</span>
            <span class="log-isp">${log.isp}</span>
            <span class="log-time">${log.timestamp.split(' ')[1]}</span>
        </div>
    `).join('');
}

function updateMap(logs) {
    if (!logs || logs.length === 0) return;
    
    // Clear existing markers
    markers.forEach(m => map.removeLayer(m));
    markers = [];
    
    // Group by coordinates
    const grouped = {};
    logs.forEach(log => {
        if (log.lat && log.lon && log.lat !== 0 && log.lon !== 0) {
            const key = `${log.lat},${log.lon}`;
            if (!grouped[key]) {
                grouped[key] = {
                    lat: log.lat,
                    lon: log.lon,
                    count: 0,
                    cities: new Set()
                };
            }
            grouped[key].count++;
            grouped[key].cities.add(log.city);
        }
    });
    
    // Add markers
    Object.values(grouped).forEach(loc => {
        const marker = L.circleMarker([loc.lat, loc.lon], {
            radius: 6,
            fillColor: '#00d4ff',
            color: '#00d4ff',
            weight: 1,
            opacity: 1,
            fillOpacity: 0.7
        }).addTo(map);
        
        // Pulse effect
        L.circleMarker([loc.lat, loc.lon], {
            radius: 15,
            fillColor: 'transparent',
            color: '#00d4ff',
            weight: 1,
            opacity: 0.5
        }).addTo(map);
        
        marker.bindPopup(`
            <div style="font-family:monospace;color:#00d4ff;background:#0d1421;padding:5px;">
                <strong>${[...loc.cities].join(', ')}</strong><br>
                Hits: ${loc.count}
            </div>
        `);
        
        markers.push(marker);
    });
    
    // Auto-fit bounds if markers exist
    if (markers.length > 0) {
        const group = L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.3));
    }
}

// Initial fetch
fetchData();

// Auto refresh every 5 seconds
setInterval(fetchData, 5000);
