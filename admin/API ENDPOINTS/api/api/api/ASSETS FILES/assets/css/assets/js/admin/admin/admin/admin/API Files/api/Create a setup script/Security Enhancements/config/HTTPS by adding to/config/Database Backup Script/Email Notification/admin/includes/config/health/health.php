<?php
header('Content-Type: application/json');

$status = [
    'status' => 'healthy',
    'timestamp' => date('c'),
    'checks' => []
];

// Check database files
$files = ['jobs.json', 'users.json', 'companies.json'];
foreach ($files as $file) {
    $path = "database/$file";
    if (file_exists($path)) {
        $size = filesize($path);
        $status['checks'][$file] = [
            'exists' => true,
            'size' => $size,
            'writable' => is_writable($path),
            'valid_json' => json_decode(file_get_contents($path)) !== null
        ];
    } else {
        $status['checks'][$file] = ['exists' => false];
    }
}

// Check error log
$errorLog = 'logs/errors.log';
if (file_exists($errorLog)) {
    $errors = file($errorLog);
    $status['errors_last_hour'] = count(array_filter($errors, function($line) {
        return strtotime(substr($line, 1, 19)) > time() - 3600;
    }));
}

// System info
$status['system'] = [
    'php_version' => phpversion(),
    'memory_usage' => memory_get_usage(true),
    'disk_free' => disk_free_space(__DIR__)
];

echo json_encode($status, JSON_PRETTY_PRINT);
?>
