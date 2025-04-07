<?php

// Database connection constants
define('DB_HOST', '2r4fb.h.filess.io');
define('DB_PORT', '61002');
define('DB_NAME', 'musiclink_developill');
define('DB_USER', 'musiclink_developill');
define('DB_PASS', 'c58c5a6214d9622ed4f8d5efdc32ebe62d89123f');

/**
 * Get database connection
 * 
 * @return PDO Database connection
 */
function getDbConnection() {
        static $pdo = null;

        // Return existing connection if available
        if ($pdo !== null) {
            return $pdo;
        }

        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                // Add connection pooling option
                PDO::ATTR_PERSISTENT => true,
            ];

            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            return $pdo;
        } catch (PDOException $e) {
            // For development, show error. For production, log error and show generic message
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Close database connection
     * 
     * @param PDO $pdo Database connection to close
     */
    function closeDbConnection(&$pdo) {
        $pdo = null;
}