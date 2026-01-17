<?php
// Create database directory if it doesn't exist
if (!is_dir('database')) {
    mkdir('database', 0755, true);
}

// Create logs directory if it doesn't exist
if (!is_dir('logs')) {
    mkdir('logs', 0755, true);
}

// Create initial data
$initialJobs = [
    [
        "id" => 1,
        "title" => "Full Stack Developer",
        "company" => "Tech Corp",
        "location" => "Addis Ababa",
        "salary" => "$50,000 - $70,000",
        "type" => "Full-time",
        "category" => "Technology",
        "description" => "We are looking for a skilled Full Stack Developer...",
        "requirements" => ["PHP", "JavaScript", "MySQL", "Laravel", "Vue.js"],
        "posted_date" => date('Y-m-d'),
        "expiry_date" => date('Y-m-d', strtotime('+30 days')),
        "status" => "active",
        "applications" => 12,
        "views" => 245
    ]
];

$initialCompanies = [
    [
        "id" => 1,
        "name" => "Tech Corp",
        "email" => "contact@techcorp.com",
        "phone" => "+251911223344",
        "website" => "https://techcorp.com",
        "location" => "Addis Ababa",
        "industry" => "Technology",
        "description" => "Leading tech company in Ethiopia",
        "logo" => "techcorp.png",
        "verified" => true,
        "jobs_posted" => 5,
        "member_since" => "2023-06-01"
    ]
];

$initialUsers = [
    [
        "id" => 1,
        "username" => "admin",
        "email" => "admin@zewedjobs.com",
        "password_hash" => password_hash('admin123', PASSWORD_DEFAULT),
        "role" => "administrator",
        "created_at" => date('Y-m-d H:i:s'),
        "last_login" => date('Y-m-d H:i:s')
    ]
];

// Write initial data
file_put_contents('database/jobs.json', json_encode($initialJobs, JSON_PRETTY_PRINT));
file_put_contents('database/companies.json', json_encode($initialCompanies, JSON_PRETTY_PRINT));
file_put_contents('database/users.json', json_encode($initialUsers, JSON_PRETTY_PRINT));

// Create empty error log
file_put_contents('logs/errors.log', '');

echo "Setup completed successfully!<br>";
echo "Admin credentials:<br>";
echo "Username: admin<br>";
echo "Password: admin123<br>";
echo "<a href='admin/login.php'>Go to Login Page</a>";
?>
