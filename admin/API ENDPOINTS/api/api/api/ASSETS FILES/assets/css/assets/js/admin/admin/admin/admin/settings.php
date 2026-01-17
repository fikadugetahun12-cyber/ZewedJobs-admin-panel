<?php
require_once '../config/config.php';
requireLogin();

$title = "Settings";
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">Settings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Settings Menu -->
        <div class="col-lg-3 mb-4">
            <div class="list-group">
                <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    <i class="bi bi-gear me-2"></i>General Settings
                </a>
                <a href="#email" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-envelope me-2"></i>Email Settings
                </a>
                <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-shield-check me-2"></i>Security
                </a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-bell me-2"></i>Notifications
                </a>
                <a href="#backup" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-cloud-arrow-down me-2"></i>Backup & Restore
                </a>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">General Settings</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Site Title</label>
                                    <input type="text" class="form-control" value="ZewedJobs Admin">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Site Description</label>
                                    <textarea class="form-control" rows="3">Job portal admin panel</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Admin Email</label>
                                    <input type="email" class="form-control" value="admin@zewedjobs.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select">
                                        <option>Africa/Addis_Ababa</option>
                                        <option>UTC</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="tab-pane fade" id="email">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Email Configuration</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" placeholder="smtp.gmail.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">SMTP Port</label>
                                    <input type="number" class="form-control" placeholder="587">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">SMTP Username</label>
                                    <input type="text" class="form-control" placeholder="your-email@gmail.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">SMTP Password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">From Email</label>
                                    <input type="email" class="form-control" placeholder="noreply@zewedjobs.com">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Email Settings</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="tab-pane fade" id="security">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Security Settings</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Session Timeout (minutes)</label>
                                    <input type="number" class="form-control" value="30" min="5">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Max Login Attempts</label>
                                    <input type="number" class="form-control" value="5" min="1">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="forceSSL">
                                    <label class="form-check-label" for="forceSSL">Force SSL/HTTPS</label>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="twoFactor" checked>
                                    <label class="form-check-label" for="twoFactor">Enable Two-Factor Authentication</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Policy</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Minimum 8 characters</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Require uppercase letter</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Require number</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Security</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Backup & Restore -->
                <div class="tab-pane fade" id="backup">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Backup & Restore</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Last backup: 2 days ago
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-3"></i>
                                            <h5>Create Backup</h5>
                                            <p class="text-muted">Backup all database files</p>
                                            <button class="btn btn-primary">
                                                <i class="bi bi-download me-2"></i>Create Backup Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="bi bi-cloud-arrow-down fs-1 text-success mb-3"></i>
                                            <h5>Restore Backup</h5>
                                            <p class="text-muted">Restore from previous backup</p>
                                            <input type="file" class="form-control mb-3">
                                            <button class="btn btn-success">
                                                <i class="bi bi-upload me-2"></i>Restore Backup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6>Recent Backups</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Size</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2 days ago</td>
                                            <td>2.4 MB</td>
                                            <td><span class="badge bg-success">Complete</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Download</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>5 days ago</td>
                                            <td>2.1 MB</td>
                                            <td><span class="badge bg-success">Complete</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Download</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
