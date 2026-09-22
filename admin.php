<?php
$logFile = 'logs/visitors.json';
$logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
$logs = array_reverse($logs ?: []);
?>
<!DOCTYPE html>
<html>
<head>
<title>TraceX | Admin</title>
<link rel="stylesheet" href="style.css">
<style>
  body { display: block; padding: 30px; }
  .admin-header { text-align: center; margin-bottom: 30px; }
  .admin-header h1 {
    font-size: 32px;
    background: linear-gradient(90deg, #00d4ff, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    letter-spacing: 3px;
  }
  .admin-header p { color: #64748b; margin-top: 8px; font-size: 13px; }
  .admin-table {
    width: 100%;
    border-collapse: collapse;
    background: #111a2b;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #1e2d45;
  }
  .admin-table th {
    background: #0d1421;
    color: #00d4ff;
    padding: 15px;
    text-align: left;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
  }
  .admin-table td {
    padding: 12px 15px;
    border-bottom: 1px solid #1e2d45;
    font-size: 13px;
    color: #e2e8f0;
  }
  .admin-table tr:hover { background: rgba(0,212,255,0.05); }
  .admin-ip { color: #00d4ff; font-family: monospace; font-weight: bold; }
  .admin-country { color: #fbbf24; }
  .admin-time { color: #64748b; font-size: 11px; }
  .back-btn {
    display: inline-block;
    padding: 10px 25px;
    background: rgba(0,212,255,0.15);
    border: 1px solid #00d4ff;
    color: #00d4ff;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 13px;
    letter-spacing: 1px;
  }
  .back-btn:hover { background: #00d4ff; color: #000; }
</style>
</head>
<body>

<div class="admin-header">
  <h1>TRACEX ADMIN PANEL</h1>
  <p>Total <?php echo count($logs); ?> visitors logged</p>
</div>

<a href="index.html" class="back-btn">← Back to Dashboard</a>

<?php if (empty($logs)): ?>
  <p style="text-align:center;padding:50px;color:#64748b;">Koi logs nahi hain abhi.</p>
<?php else: ?>
<table class="admin-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Time</th>
      <th>IP</th>
      <th>Country</th>
      <th>City</th>
      <th>ISP</th>
      <th>Device</th>
      <th>Referrer</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($logs as $i => $log): ?>
    <tr>
      <td><?php echo $i + 1; ?></td>
      <td class="admin-time"><?php echo htmlspecialchars($log['timestamp'] ?? '-'); ?></td>
      <td class="admin-ip"><?php echo htmlspecialchars($log['ip'] ?? '-'); ?></td>
      <td class="admin-country"><?php echo htmlspecialchars($log['country'] ?? '-'); ?></td>
      <td><?php echo htmlspecialchars($log['city'] ?? '-'); ?></td>
      <td><?php echo htmlspecialchars($log['isp'] ?? '-'); ?></td>
      <td><?php echo htmlspecialchars(substr($log['user_agent'] ?? '-', 0, 40)); ?>...</td>
      <td><?php echo htmlspecialchars($log['referrer'] ?? 'Direct'); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>

</body>
</html>
