<?php
// Define base path
define('BASE_PATH', dirname(__DIR__));

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

// Include database functions
require_once BASE_PATH . '/config/database.php';

try {
    // Test connection
    echo "<p>Attempting to connect to database...</p>";
    $pdo = getDbConnection();
    echo "<p style='color:green'>Database connection successful!</p>";
    
    // Test a simple query
    echo "<p>Testing a simple query...</p>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<p>Database tables:</p>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // Close connection
    $pdo = null;
} catch (Exception $e) {
    echo "<p style='color:red'>Database connection failed: " . $e->getMessage() . "</p>";
}