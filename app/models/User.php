<?php

require_once __DIR__ . '/../../config/database.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = getDbConnection();
    }
    
    /**
     * Create a new user
     * 
     * @param array $userData User data (email, name, etc.)
     * @param string $authProvider Authentication provider (email, google, spotify)
     * @param string|null $providerId Provider's unique ID for the user
     * @param string|null $password Plain text password (for email auth)
     * @return int|bool User ID or false on failure
     */
    public function create($userData, $authProvider = 'email', $providerId = null, $password = null) {
        try {
            $passwordHash = null;
            if ($authProvider === 'email' && $password) {
                $config = require __DIR__ . '/../../config/app.php';
                $passwordHash = password_hash($password, $config['auth']['password_algorithm']);
            }
            
            $stmt = $this->db->prepare("
                INSERT INTO users (email, name, password_hash, auth_provider, auth_provider_id)
                VALUES (:email, :name, :password_hash, :auth_provider, :auth_provider_id)
            ");
            
            $stmt->execute([
                ':email' => $userData['email'],
                ':name' => $userData['name'] ?? null,
                ':password_hash' => $passwordHash,
                ':auth_provider' => $authProvider,
                ':auth_provider_id' => $providerId,
            ]);
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Handle duplicate email or other errors
            error_log('Error creating user: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Find user by email
     * 
     * @param string $email User email
     * @return array|false User data or false if not found
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }
    
    /**
     * Find user by provider ID
     * 
     * @param string $provider Auth provider name
     * @param string $providerId Provider's unique user ID
     * @return array|false User data or false if not found
     */
    public function findByProviderId($provider, $providerId) {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE auth_provider = :provider AND auth_provider_id = :provider_id
            LIMIT 1
        ");
        $stmt->execute([
            ':provider' => $provider,
            ':provider_id' => $providerId,
        ]);
        return $stmt->fetch();
    }
    
    /**
     * Verify password for email auth
     * 
     * @param string $email User email
     * @param string $password Password to verify
     * @return array|false User data or false if invalid
     */
    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);
        
        if (!$user || $user['auth_provider'] !== 'email') {
            return false;
        }
        
        if (password_verify($password, $user['password_hash'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Count smart links created by a user
     * 
     * @param int $userId User ID
     * @return int Number of smart links
     */
    public function countSmartLinks($userId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM smart_links WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return (int) $stmt->fetchColumn();
    }
}
