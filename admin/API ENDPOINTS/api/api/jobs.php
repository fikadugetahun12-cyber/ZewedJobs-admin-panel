<?php
header('Content-Type: application/json');
require_once '../config/config.php';

// Check authentication for all operations except GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
}

$action = $_GET['action'] ?? '';
$response = ['success' => false, 'message' => ''];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $jobs = readJSON(JOBS_DB);
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $job = array_filter($jobs, fn($j) => $j['id'] == $id);
            $response['success'] = !empty($job);
            $response['data'] = array_values($job)[0] ?? null;
        } else {
            // Filtering
            $filtered = $jobs;
            
            if (isset($_GET['status'])) {
                $filtered = array_filter($filtered, fn($j) => $j['status'] === $_GET['status']);
            }
            
            if (isset($_GET['company'])) {
                $filtered = array_filter($filtered, fn($j) => $j['company'] === $_GET['company']);
            }
            
            if (isset($_GET['search'])) {
                $search = strtolower($_GET['search']);
                $filtered = array_filter($filtered, fn($j) => 
                    stripos($j['title'], $search) !== false || 
                    stripos($j['description'], $search) !== false
                );
            }
            
            $response['success'] = true;
            $response['data'] = array_values($filtered);
            $response['total'] = count($filtered);
        }
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        
        if ($action === 'create') {
            $jobs = readJSON(JOBS_DB);
            $nextId = !empty($jobs) ? max(array_column($jobs, 'id')) + 1 : 1;
            
            $job = [
                'id' => $nextId,
                'title' => $data['title'] ?? '',
                'company' => $data['company'] ?? '',
                'location' => $data['location'] ?? '',
                'salary' => $data['salary'] ?? '',
                'type' => $data['type'] ?? 'Full-time',
                'category' => $data['category'] ?? 'Technology',
                'description' => $data['description'] ?? '',
                'requirements' => $data['requirements'] ?? [],
                'posted_date' => date('Y-m-d'),
                'expiry_date' => $data['expiry_date'] ?? '',
                'status' => $data['status'] ?? 'active',
                'applications' => 0,
                'views' => 0
            ];
            
            $jobs[] = $job;
            writeJSON(JOBS_DB, $jobs);
            
            $response['success'] = true;
            $response['message'] = 'Job created successfully';
            $response['id'] = $nextId;
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'] ?? 0;
        
        if ($id) {
            $jobs = readJSON(JOBS_DB);
            $found = false;
            
            foreach ($jobs as &$job) {
                if ($job['id'] == $id) {
                    $job = array_merge($job, $data);
                    $found = true;
                    break;
                }
            }
            
            if ($found) {
                writeJSON(JOBS_DB, $jobs);
                $response['success'] = true;
                $response['message'] = 'Job updated successfully';
            } else {
                $response['message'] = 'Job not found';
            }
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'] ?? 0;
        
        if ($id) {
            $jobs = readJSON(JOBS_DB);
            $initialCount = count($jobs);
            $jobs = array_filter($jobs, fn($job) => $job['id'] != $id);
            
            if (count($jobs) < $initialCount) {
                writeJSON(JOBS_DB, array_values($jobs));
                $response['success'] = true;
                $response['message'] = 'Job deleted successfully';
            } else {
                $response['message'] = 'Job not found';
            }
        }
        break;
}

echo json_encode($response);
?>
