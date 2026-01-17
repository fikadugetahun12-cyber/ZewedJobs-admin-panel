function logActivity($action, $details = '') {
    $log = [
        'timestamp' => date('Y-m-d H:i:s'),
        'user' => $_SESSION['admin_username'] ?? 'system',
        'action' => $action,
        'details' => $details,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    
    $activities = readJSON(DB_PATH . 'activities.json');
    $activities[] = $log;
    writeJSON(DB_PATH . 'activities.json', $activities);
}
