<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$logDir = 'logs/';
if (!file_exists($logDir)) mkdir($logDir, 0777, true);

function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    return $_SERVER['REMOTE_ADDR'];
}

$ip = getRealIP();
$data = json_decode(file_get_contents('php://input'), true) ?: [];

// Geo API (with lat/lon for map)
$geo = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,regionName,city,isp,org,as,lat,lon,timezone");
$geoData = $geo ? json_decode($geo, true) : [];

$logEntry = [
    'id' => uniqid('v_'),
    'timestamp' => date('Y-m-d H:i:s'),
    'ip' => $ip,
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
    'language' => $data['lang'] ?? 'Unknown',
    'platform' => $data['platform'] ?? 'Unknown',
    'screen' => $data['screen'] ?? 'Unknown',
    'timezone' => $data['timezone'] ?? 'Unknown',
    'referrer' => $data['referrer'] ?? 'Direct',
    'country' => $geoData['country'] ?? 'Unknown',
    'countryCode' => $geoData['countryCode'] ?? 'XX',
    'region' => $geoData['regionName'] ?? 'Unknown',
    'city' => $geoData['city'] ?? 'Unknown',
    'isp' => $geoData['isp'] ?? 'Unknown',
    'org' => $geoData['org'] ?? 'Unknown',
    'lat' => $geoData['lat'] ?? 0,
    'lon' => $geoData['lon'] ?? 0
];

$logFile = $logDir . 'visitors.json';
$existing = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
$existing = $existing ?: [];
$existing[] = $logEntry;
file_put_contents($logFile, json_encode($existing, JSON_PRETTY_PRINT));

echo json_encode(['status' => 'logged', 'id' => $logEntry['id']]);
?>
