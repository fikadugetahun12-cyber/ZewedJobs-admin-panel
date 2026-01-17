<?php
require_once '../config/config.php';
requireLogin();

$title = "Reports";
$scripts = [];
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">Reports & Analytics</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Date Range Picker -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Report Type</label>
                    <select class="form-select">
                        <option>Summary Report</option>
                        <option>Jobs Report</option>
                        <option>Users Report</option>
                        <option>Companies Report</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-2"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Job Applications Trend</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Job Categories Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Applications</h6>
                    <h2>1,254</h2>
                    <small class="text-success"><i class="bi bi-arrow-up"></i> 12% from last month</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted">Active Jobs</h6>
                    <h2>89</h2>
                    <small class="text-success"><i class="bi bi-arrow-up"></i> 8% from last month</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted">New Users</h6>
                    <h2>156</h2>
                    <small class="text-success"><i class="bi bi-arrow-up"></i> 23% from last month</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted">New Companies</h6>
                    <h2>24</h2>
                    <small class="text-success"><i class="bi bi-arrow-up"></i> 15% from last month</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detailed Report</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>New Jobs</th>
                            <th>New Users</th>
                            <th>New Companies</th>
                            <th>Applications</th>
                            <th>Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 7; $i >= 0; $i--): ?>
                        <tr>
                            <td><?php echo date('M d, Y', strtotime("-$i days")); ?></td>
                            <td><?php echo rand(5, 20); ?></td>
                            <td><?php echo rand(10, 30); ?></td>
                            <td><?php echo rand(1, 5); ?></td>
                            <td><?php echo rand(20, 100); ?></td>
                            <td><?php echo rand(15, 45); ?>%</td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    // Applications Chart
    const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(applicationsCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Applications',
                data: [120, 190, 300, 500],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Categories Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Technology', 'Marketing', 'Finance', 'Healthcare', 'Other'],
            datasets: [{
                data: [45, 25, 15, 10, 5],
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
