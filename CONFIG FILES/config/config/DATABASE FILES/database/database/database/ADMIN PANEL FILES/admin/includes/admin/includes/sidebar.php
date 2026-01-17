<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="sidebar" class="bg-dark text-white">
    <div class="sidebar-header p-4">
        <h3 class="mb-0">
            <i class="bi bi-briefcase me-2"></i>
            ZewedJobs
        </h3>
        <small class="text-muted">Admin Panel</small>
    </div>
    
    <ul class="list-unstyled components">
        <li class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
            <a href="index.php">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>
        
        <li class="<?php echo in_array($current_page, ['jobs.php', 'add-job.php', 'edit-job.php']) ? 'active' : ''; ?>">
            <a href="#jobsSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-briefcase me-2"></i>
                Jobs
            </a>
            <ul class="collapse list-unstyled" id="jobsSubmenu">
                <li>
                    <a href="jobs.php"><i class="bi bi-list-ul me-2"></i>All Jobs</a>
                </li>
                <li>
                    <a href="add-job.php"><i class="bi bi-plus-circle me-2"></i>Add New</a>
                </li>
                <li>
                    <a href="job-applications.php"><i class="bi bi-people me-2"></i>Applications</a>
                </li>
            </ul>
        </li>
        
        <li class="<?php echo in_array($current_page, ['companies.php', 'add-company.php']) ? 'active' : ''; ?>">
            <a href="companies.php">
                <i class="bi bi-building me-2"></i>
                Companies
            </a>
        </li>
        
        <li class="<?php echo $current_page == 'users.php' ? 'active' : ''; ?>">
            <a href="users.php">
                <i class="bi bi-people me-2"></i>
                Users
            </a>
        </li>
        
        <li class="<?php echo $current_page == 'reports.php' ? 'active' : ''; ?>">
            <a href="reports.php">
                <i class="bi bi-bar-chart me-2"></i>
                Reports
            </a>
        </li>
        
        <li class="<?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
            <a href="settings.php">
                <i class="bi bi-gear me-2"></i>
                Settings
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer p-3">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <i class="bi bi-shield-check fs-4 text-success"></i>
            </div>
            <div>
                <small class="d-block">Secure Admin</small>
                <small class="text-muted">Last login: Today</small>
            </div>
        </div>
    </div>
</nav>
