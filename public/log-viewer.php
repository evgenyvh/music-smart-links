// Create a file called log-viewer.php in your public directory
// IMPORTANT: Only use in development/debugging, remove afterwards!
<?php
// Set a simple password to protect your logs
$password = 'evgeny';

if (!isset($_GET['password']) || $_GET['password'] !== $password) {
    die('Unauthorized');
}

$logFile = __DIR__ . '/../storage/logs/app.log';

if (file_exists($logFile)) {
    echo "<h1>Application Logs</h1>";
    echo "<pre>" . htmlspecialchars(file_get_contents($logFile)) . "</pre>";
} else {
    echo "No log file found at: $logFile";
}