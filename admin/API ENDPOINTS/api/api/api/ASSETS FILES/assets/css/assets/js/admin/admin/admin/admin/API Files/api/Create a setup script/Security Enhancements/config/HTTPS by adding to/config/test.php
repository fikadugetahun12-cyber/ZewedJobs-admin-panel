<?php
echo "<h1>ZewedJobs Admin - Installation Test</h1>";

// Test 1: PHP Version
echo "<h3>1. PHP Version: " . phpversion() . "</h3>";
echo phpversion() >= '7.4' ? '✅ OK' : '❌ Requires PHP 7.4+';

// Test 2: Required Extensions
echo "<h3>2. Required Extensions:</h3>";
$required = ['json', 'session'];
foreach ($required as $ext) {
    echo extension_loaded($ext) ? "✅ $ext" : "❌ $ext";
    echo "<br>";
}

// Test 3: Directory Permissions
echo "<h3>3. Directory Permissions:</h3>";
$dirs = ['database', 'logs'];
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        echo is_writable($dir) ? "✅ $dir is writable" : "❌ $dir is not writable";
    } else {
        echo "❌ $dir does not exist";
    }
    echo "<br>";
}

// Test 4: JSON Functions
echo "<h3>4. JSON Functions:</h3>";
$testData = ['test' => true];
$json = json_encode($testData);
echo $json === '{"test":true}' ? '✅ JSON encode working' : '❌ JSON encode error';
echo "<br>";
$decoded = json_decode($json, true);
echo $decoded['test'] ? '✅ JSON decode working' : '❌ JSON decode error';

// Test 5: Session
echo "<h3>5. Session Support:</h3>";
session_start();
$_SESSION['test'] = 'working';
echo isset($_SESSION['test']) ? '✅ Sessions working' : '❌ Session error';

echo "<hr>";
echo "<h2>Next Steps:</h2>";
echo "1. Run setup.php to initialize database<br>";
echo "2. Access admin panel at /admin/login.php<br>";
echo "3. Login with admin/admin123<br>";
?>
