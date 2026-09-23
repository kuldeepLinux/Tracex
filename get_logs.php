<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$logFile = 'logs/visitors.json';

// Agar file nahi hai toh khaali array
$logs = [];
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    $logs = json_decode($content, true);
    if (!is_array($logs)) {
        $logs = [];
    }
}

// Latest first
$logs = array_reverse($logs);

// Statistics calculate karein
$stats = [
    'totalVisits' => count($logs),
    'uniqueIPs' => count(array_unique(array_column($logs, 'ip'))),
    'countries' => count(array_unique(array_column($logs, 'country'))),
    'isps' => count(array_unique(array_column($logs, 'isp')))
];

// Latest 10 logs
$recent = array_slice($logs, 0, 10);

// JSON output
echo json_encode([
    'stats' => $stats,
    'logs' => $logs,
    'recent' => $recent
]);
?>
