<?php
// Logs folder aur visitors.json fix karo
$dir = 'logs/';
$file = $dir . 'visitors.json';

// Folder nahi hai to banao
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}
chmod($dir, 0777);

// visitors.json nahi hai to banao
if (!file_exists($file)) {
    file_put_contents($file, '[]');
}
chmod($file, 0666);

echo "Logs folder aur visitors.json fix ho gayi!";
echo "<br>Folder permission: " . substr(sprintf('%o', fileperms($dir)), -4);
echo "<br>File permission: " . substr(sprintf('%o', fileperms($file)), -4);
echo "<br>Writable: " . (is_writable($file) ? "Yes" : "No");
echo "<br>File content: " . file_get_contents($file);
?>
