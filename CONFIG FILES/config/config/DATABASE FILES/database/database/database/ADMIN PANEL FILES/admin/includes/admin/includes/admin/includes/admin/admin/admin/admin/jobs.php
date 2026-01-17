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
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="company" class="form-label">Company *</label>
                            <select class="form-select" id="company" name="company" required>
                                <option value="">Select Company</option>
                                <?php foreach ($companies as $company): ?>
                                <option value="<?php echo htmlspecialchars($company['name']); ?>"
                                    <?php echo ($_POST['company'] ?? '') === $company['name'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($company['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="location" class="form-label">Location *</label>
                                <input type="text" class="form-control" id="location" name="location" 
                                       value="<?php echo htmlspecialchars($_POST['location'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="salary" class="form-label">Salary Range</label>
                                <input type="text" class="form-control" id="salary" name="salary" 
                                       value="<?php echo htmlspecialchars($_POST['salary'] ?? ''); ?>" 
                                       placeholder="e.g., $50,000 - $70,000">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="type" class="form-label">Job Type</label>
                                <select class="form-select" id="type" name="type">
                                    <option value="Full-time" <?php echo ($_POST['type'] ?? '') === 'Full-time' ? 'selected' : ''; ?>>Full-time</option>
                                    <option value="Part-time" <?php echo ($_POST['type'] ?? '') === 'Part-time' ? 'selected' : ''; ?>>Part-time</option>
                                    <option value="Contract" <?php echo ($_POST['type'] ?? '') === 'Contract' ? 'selected' : ''; ?>>Contract</option>
                                    <option value="Internship" <?php echo ($_POST['type'] ?? '') === 'Internship' ? 'selected' : ''; ?>>Internship</option>
                                    <option value="Remote" <?php echo ($_POST['type'] ?? '') === 'Remote' ? 'selected' : ''; ?>>Remote</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="Technology" <?php echo ($_POST['category'] ?? '') === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                                    <option value="Marketing" <?php echo ($_POST['category'] ?? '') === 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                                    <option value="Finance" <?php echo ($_POST['category'] ?? '') === 'Finance' ? 'selected' : ''; ?>>Finance</option>
                                    <option value="Healthcare" <?php echo ($_POST['category'] ?? '') === 'Healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                                    <option value="Education" <?php echo ($_POST['category'] ?? '') === 'Education' ? 'selected' : ''; ?>>Education</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Job Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="8" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="requirements" class="form-label">Requirements (one per line)</label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="4"><?php echo htmlspecialchars($_POST['requirements'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Publish Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" 
                                   value="<?php echo $_POST['expiry_date'] ?? ''; ?>"
                                   min="<?php echo date('Y-m-d'); ?>">
                            <small class="text-muted">Leave empty for no expiry</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_active" value="active" checked>
                                <label class="form-check-label" for="status_active">
                                    <span class="badge bg-success">Active</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive">
                                <label class="form-check-label" for="status_inactive">
                                    <span class="badge bg-warning">Inactive</span>
                                </label>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Publish Job
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Job Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Job ID</label>
                            <input type="text" class="form-control" value="JOB-<?php echo str_pad($nextId, 5, '0', STR_PAD_LEFT); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Posted Date</label>
                            <input type="text" class="form-control" value="<?php echo date('F d, Y'); ?>" readonly>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Applications</label>
                            <input type="text" class="form-control" value="0" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
CKEDITOR.replace('description', {
    toolbar: [
        ['Bold', 'Italic', 'Underline', 'Strike'],
        ['NumberedList', 'BulletedList'],
        ['Link', 'Unlink'],
        ['RemoveFormat']
    ],
    height: 200
});
</script>

<?php
include 'includes/footer.php';
?>
