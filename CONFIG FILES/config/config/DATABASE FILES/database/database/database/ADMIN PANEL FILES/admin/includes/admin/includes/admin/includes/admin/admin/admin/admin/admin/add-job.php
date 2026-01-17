<?php
require_once '../config/config.php';
requireLogin();

// Get companies for dropdown
$companies = readJSON(COMPANIES_DB);

// Generate next job ID
$jobs = readJSON(JOBS_DB);
$nextId = !empty($jobs) ? max(array_column($jobs, 'id')) + 1 : 1;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $job = [
            'id' => $nextId,
            'title' => $_POST['title'] ?? '',
            'company' => $_POST['company'] ?? '',
            'location' => $_POST['location'] ?? '',
            'salary' => $_POST['salary'] ?? '',
            'type' => $_POST['type'] ?? '',
            'category' => $_POST['category'] ?? '',
            'description' => $_POST['description'] ?? '',
            'requirements' => explode("\n", $_POST['requirements'] ?? ''),
            'posted_date' => date('Y-m-d'),
            'expiry_date' => $_POST['expiry_date'] ?? '',
            'status' => 'active',
            'applications' => 0,
            'views' => 0
        ];
        
        // Validate required fields
        $required = ['title', 'company', 'location', 'description'];
        foreach ($required as $field) {
            if (empty($job[$field])) {
                throw new Exception("Please fill in all required fields");
            }
        }
        
        // Add to jobs array
        $jobs[] = $job;
        writeJSON(JOBS_DB, $jobs);
        
        $success = 'Job posted successfully!';
        
        // Clear form
        $_POST = [];
        $nextId++;
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        logError("Error adding job: " . $e->getMessage());
    }
}

$title = "Add New Job";
$scripts = ['https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js'];
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">Add New Job</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="jobs.php">Jobs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New</li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Job Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title *</label>
                            <input type="text" class="form
