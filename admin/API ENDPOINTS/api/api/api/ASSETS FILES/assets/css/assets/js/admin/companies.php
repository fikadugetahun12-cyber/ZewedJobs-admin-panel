<?php
require_once '../config/config.php';
requireLogin();

$companies = readJSON(COMPANIES_DB);
$title = "Companies";
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">Companies</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Companies</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Companies (<?php echo count($companies); ?>)</h5>
            <a href="add-company.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Company
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Jobs Posted</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($companies as $company): ?>
                        <tr>
                            <td>#<?php echo $company['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($company['name']); ?></strong><br>
                                <small class="text-muted"><?php echo $company['industry']; ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($company['email']); ?></td>
                            <td><?php echo htmlspecialchars($company['phone']); ?></td>
                            <td><?php echo htmlspecialchars($company['location']); ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo $company['jobs_posted']; ?> jobs</span>
                            </td>
                            <td>
                                <?php if ($company['verified']): ?>
                                <span class="badge bg-success">Verified</span>
                                <?php else: ?>
                                <span class="badge bg-warning">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="edit-company.php?id=<?php echo $company['id']; ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php if (!$company['verified']): ?>
                                    <a href="?verify=<?php echo $company['id']; ?>" class="btn btn-outline-success">
                                        <i class="bi bi-check-circle"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="?delete=<?php echo $company['id']; ?>" 
                                       class="btn btn-outline-danger"
                                       onclick="return confirm('Delete this company?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
