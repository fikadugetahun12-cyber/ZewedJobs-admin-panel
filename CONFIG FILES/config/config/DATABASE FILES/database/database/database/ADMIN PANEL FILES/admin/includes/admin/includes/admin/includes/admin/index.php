<?php
require_once '../config/config.php';
requireLogin();

// Get statistics
$jobs = readJSON(JOBS_DB);
$users = readJSON(USERS_DB);
$companies = readJSON(COMPANIES_DB);

$stats = [
    'total_jobs' => count($jobs),
    'active_jobs' => count(array_filter($jobs, fn($job) => $job['status'] === 'active')),
    'total_users' => count($users),
    'total_companies' => count($companies),
    'pending_companies' => count(array_filter($companies, fn($company) => !$company['verified'])),
    'today_jobs' => count(array_filter($jobs, fn($job) => $job['posted_date'] === date('Y-m-d')))
];

// Recent jobs
$recent_jobs = array_slice($jobs, -5);

// Recent users
$recent_users = array_slice($users, -5);

$title = "Dashboard";
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">Dashboard</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-white-50">Total Jobs</h6>
                            <h2 class="mb-0"><?php echo $stats['total_jobs']; ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-briefcase fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-white-50">Active Jobs</h6>
                            <h2 class="mb-0"><?php echo $stats['active_jobs']; ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-check-circle fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-white-50">Total Users</h6>
                            <h2 class="mb-0"><?php echo $stats['total_users']; ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Companies</h6>
                            <h2 class="mb-0"><?php echo $stats['total_companies']; ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-building fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activities -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Job Postings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Posted</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_jobs as $job): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                                    <td><?php echo htmlspecialchars($job['company']); ?></td>
                                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                                    <td><?php echo $job['posted_date']; ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $job['status'] === 'active' ? 'success' : 'warning'; ?>">
                                            <?php echo ucfirst($job['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Users</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($recent_users as $user): ?>
                        <div class="list-group-item border-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0"><?php echo htmlspecialchars($user['username']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($user['email']); ?></small>
                                </div>
                                <span class="badge bg-<?php echo $user['role'] === 'administrator' ? 'danger' : 'info'; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="add-job.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Add New Job
                        </a>
                        <a href="add-company.php" class="btn btn-success">
                            <i class="bi bi-building-add me-2"></i>Add Company
                        </a>
                        <a href="reports.php" class="btn btn-info">
                            <i class="bi bi-bar-chart me-2"></i>View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
