<?php
header('Content-Type: application/json');
require_once '../config/config.php';

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';
$response = ['success' => false, 'message' => ''];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $companies = readJSON(COMPANIES_DB);
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $company = array_filter($companies, fn($c) => $c['id'] == $id);
            $response['success'] = !empty($company);
            $response['data'] = array_values($company)[0] ?? null;
        } else {
            $response['success'] = true;
            $response['data'] = $companies;
        }
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        
        if ($action === 'create') {
            $companies = readJSON(COMPANIES_DB);
            $nextId = !empty($companies) ? max(array_column($companies, 'id')) + 1 : 1;
            
            $company = [
                'id' => $nextId,
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'phone' => $data['phone'] ?? '',
                'website' => $data['website'] ?? '',
                'location' => $data['location'] ?? '',
                'industry' => $data['industry'] ?? '',
                'description' => $data['description'] ?? '',
                'logo' => $data['logo'] ?? '',
                'verified' => $data['verified'] ?? false,
                'jobs_posted' => 0,
                'member_since' => date('Y-m-d')
            ];
            
            $companies[] = $company;
            writeJSON(COMPANIES_DB, $companies);
            
            $response['success'] = true;
            $response['message'] = 'Company added successfully';
        } elseif ($action === 'verify') {
            $id = $_GET['id'] ?? 0;
            if ($id) {
                $companies = readJSON(COMPANIES_DB);
                foreach ($companies as &$company) {
                    if ($company['id'] == $id) {
                        $company['verified'] = true;
                        break;
                    }
                }
                writeJSON(COMPANIES_DB, $companies);
                $response['success'] = true;
                $response['message'] = 'Company verified';
            }
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $companies = readJSON(COMPANIES_DB);
            $initialCount = count($companies);
            $companies = array_filter($companies, fn($c) => $c['id'] != $id);
            
            if (count($companies) < $initialCount) {
                writeJSON(COMPANIES_DB, array_values($companies));
                $response['success'] = true;
                $response['message'] = 'Company deleted';
            }
        }
        break;
}

echo json_encode($response);
?>
