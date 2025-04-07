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
                // Disable connection pooling to avoid max_user_connections issues
                PDO::ATTR_PERSISTENT => false,
            ];

            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            return $pdo;
        } catch (PDOException $e) {
            // Log the error
            error_log('Database connection error: ' . $e->getMessage());

            // For development, show a more user-friendly message
            if (strpos($e->getMessage(), 'max_user_connections') !== false) {
                die('Database connection limit reached. Please try again in a few moments.');
            } else {
                die('Database connection failed. Please try again later.');
            }
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

    /**
     * Execute a database query with proper connection handling
     * 
     * @param callable $callback Function that executes the query
     * @return mixed Result of the callback
     */
    function withDbConnection($callback) {
        $pdo = getDbConnection();
        try {
            $result = $callback($pdo);
            return $result;
        } finally {
            // Always close the connection when done
            closeDbConnection($pdo);
        }
}