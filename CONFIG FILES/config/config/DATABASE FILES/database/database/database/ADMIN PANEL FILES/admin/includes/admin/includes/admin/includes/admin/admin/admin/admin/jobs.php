<?php
require_once '../config/config.php';
requireLogin();

$jobs = readJSON(JOBS_DB);

// Handle job deletion
if (isset($_GET['delete'])) {
    $jobId = (int)$_GET['delete'];
    $jobs = array_filter($jobs, fn($job) => $job['id'] !== $jobId);
    writeJSON(JOBS_DB, array_values($jobs));
    header('Location: jobs.php?deleted=true');
    exit;
}

// Handle status change
if (isset($_GET['toggle'])) {
    $jobId = (int)$_GET['toggle'];
    foreach ($jobs as &$job) {
        if ($job['id'] === $jobId) {
            $job['status'] = $job['status'] === 'active' ? 'inactive' : 'active';
            break;
        }
    }
    writeJSON(JOBS_DB, $jobs);
    header('Location: jobs.php?updated=true');
    exit;
}

// Search and filter
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$category = $_GET['category'] ?? '';

if ($search || $status || $category) {
    $jobs = array_filter($jobs, function($job) use ($search, $status, $category) {
        $matches = true;
        if ($search) {
            $matches = $matches && (stripos($job['title'], $search) !== false || 
                     stripos($job['company'], $search) !== false);
        }
        if ($status) {
            $matches = $matches && ($job['status'] === $status);
        }
        if ($category) {
            $matches = $matches && ($job['category'] === $category);
        }
        return $matches;
    });
}

$title = "Manage Jobs";
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">Manage Jobs</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jobs</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Success Messages -->
    <?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Job deleted successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Job status updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Search jobs..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="expired" <?php echo $status === 'expired' ? 'selected' : ''; ?>>Expired</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <option value="Technology" <?php echo $category === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                        <option value="Marketing" <?php echo $category === 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                        <option value="Finance" <?php echo $category === 'Finance' ? 'selected' : ''; ?>>Finance</option>
                        <option value="Healthcare" <?php echo $category === 'Healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Jobs (<?php echo count($jobs); ?>)</h5>
            <a href="add-job.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Job
            </a>
        </div>
        <div class="card-body">
            <?php if (empty($jobs)): ?>
            <div class="text-center py-5">
                <i class="bi bi-briefcase fs-1 text-muted"></i>
                <h5 class="mt-3">No jobs found</h5>
                <p class="text-muted">Try adjusting your search or add a new job.</p>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Salary</th>
                            <th>Posted</th>
                            <th>Applications</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td>#<?php echo $job['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($job['title']); ?></strong><br>
                                <small class="text-muted"><?php echo $job['type']; ?> • <?php echo $job['category']; ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($job['company']); ?></td>
                            <td><?php echo htmlspecialchars($job['location']); ?></td>
                            <td><?php echo htmlspecialchars($job['salary']); ?></td>
                            <td><?php echo $job['posted_date']; ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo $job['applications']; ?> apps</span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $job['status'] === 'active' ? 'success' : 'warning'; ?>">
                                    <?php echo ucfirst($job['status']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="edit-job.php?id=<?php echo $job['id']; ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="?toggle=<?php echo $job['id']; ?>" class="btn btn-outline-<?php echo $job['status'] === 'active' ? 'warning' : 'success'; ?>">
                                        <i class="bi bi-power"></i>
                                    </a>
                                    <a href="?delete=<?php echo $job['id']; ?>" 
                                       class="btn btn-outline-danger"
                                       onclick="return confirm('Are you sure you want to delete this job?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
