<?php
// Debug information
echo "<h1>PHP Debug Information</h1>";
echo "<pre>";

// Show the BASE_PATH value
echo "BASE_PATH: " . (defined('BASE_PATH') ? BASE_PATH : 'Not defined') . "\n\n";

// Show the current directory
echo "Current Directory: " . getcwd() . "\n\n";

// Show the directory of this script
echo "Script Directory: " . __DIR__ . "\n\n";

// Check if key files exist
$files_to_check = [
    '/app/views/layout.php',
    '/app/views/home.php',
    '/app/views/home_content.php',
    '/app/views/auth/login.php',
    '/app/views/auth/register.php'
];

echo "Checking for files:\n";
foreach ($files_to_check as $file) {
    $full_path = dirname(__DIR__) . $file;
    echo $full_path . ": " . (file_exists($full_path) ? "EXISTS" : "MISSING") . "\n";
}

echo "\n\nEnvironment Variables:\n";
print_r($_ENV);

echo "\n\nServer Variables:\n";
print_r($_SERVER);

echo "</pre>";