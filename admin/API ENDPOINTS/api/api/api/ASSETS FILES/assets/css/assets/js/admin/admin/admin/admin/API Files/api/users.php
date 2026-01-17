<?php
header('Content-Type: application/json');
require_once '../config/config.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$response = ['success' => false, 'message' => ''];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $users = readJSON(USERS_DB);
        $response['success'] = true;
        $response['data'] = $users;
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $users = readJSON(USERS_DB);
        
        $nextId = !empty($users) ? max(array_column($users, 'id')) + 1 : 1;
        $newUser = [
            'id' => $nextId,
            'username' => $data['username'] ?? '',
            'email' => $data['email'] ?? '',
            'password_hash' => password_hash($data['password'] ?? 'password', PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'job_seeker',
            'created_at' => date('Y-m-d H:i:s'),
            'last_login' => null
        ];
        
        $users[] = $newUser;
        writeJSON(USERS_DB, $users);
        
        $response['success'] = true;
        $response['message'] = 'User created';
        break;
}

echo json_encode($response);
?>
