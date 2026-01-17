<?php
// Run via cron: 0 2 * * * /usr/bin/php /path/to/backup.php

$backupDir = 'backups/' . date('Y-m');
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$files = [
    'database/jobs.json',
    'database/users.json', 
    'database/companies.json'
];

$backupFile = $backupDir . '/backup-' . date('Y-m-d-H-i-s') . '.zip';

$zip = new ZipArchive();
if ($zip->open($backupFile, ZipArchive::CREATE) === TRUE) {
    foreach ($files as $file) {
        if (file_exists($file)) {
            $zip->addFile($file, basename($file));
        }
    }
    $zip->close();
    
    // Keep only last 30 days of backups
    $backups = glob($backupDir . '/*.zip');
    usort($backups, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    foreach (array_slice($backups, 30) as $oldBackup) {
        unlink($oldBackup);
    }
    
    echo "Backup created: $backupFile";
}
?>
