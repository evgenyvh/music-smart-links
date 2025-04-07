<?php
// Test database connection
try {
    $pdo = getDbConnection();
    closeDbConnection($pdo);
    $dbStatus = 'Connected';
} catch (Exception $e) {
    $dbStatus = 'Error: ' . $e->getMessage();
}

$pageTitle = 'Music Smart Links - Share Your Music Everywhere';
ob_start();
include BASE_PATH . '/app/views/home_content.php';
$content = ob_get_clean();
include BASE_PATH . '/app/views/layout.php';
?>