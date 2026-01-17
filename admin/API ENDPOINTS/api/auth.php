<?php
header('Content-Type: application/json');
require_once '../config/config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';
    
    switch ($action) {
        case 'login':
            $data = json_decode(file_get_contents('php://input'), true);
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            
            if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                $response['success'] = true;
                $response['message'] = 'Login successful';
            } else {
                $response['message'] = 'Invalid credentials';
            }
            break;
            
        case 'logout':
            session_destroy();
            $response['success'] = true;
            $response['message'] = 'Logged out successfully';
            break;
            
        case 'check':
            $response['success'] = isLoggedIn();
            $response['message'] = isLoggedIn() ? 'Authenticated' : 'Not authenticated';
            break;
    }
}

echo json_encode($response);
?>
