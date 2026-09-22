<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$logFile = 'logs/visitors.json';
$logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
$logs = array_reverse($logs ?: []);

// Stats
$stats = [
    'totalVisits' => count($logs),
    'uniqueIPs' => count(array_unique(array_column($logs, 'ip'))),
    'countries' => count(array_unique(array_column($logs, 'country'))),
    'isps' => count(array_unique(array_column($logs, 'isp')))
];

// Latest 10 logs
$recent = array_slice($logs, 0, 10);

echo json_encode([
    'stats' => $stats,
    'logs' => $logs,
    'recent' => $recent
]);
?>
