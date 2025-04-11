<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../services/EmailVerificationService.php';

class AuthController {
    private $userModel;
    private $emailVerifier;
    
    public function __construct() {
        $this->userModel = new User();
        $this->emailVerifier = new EmailVerificationService();
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Register a new user
     * 
     * @param array $data Registration data
     * @return array Result with success status and message
     */
    public function register($data) {
        // Validate required fields
        if (empty($data['email']) || (empty($data['password']) && $data['auth_provider'] === 'email')) {
            return [
                'success' => false,
                'message' => 'Email and password are required',
            ];
        }
        
        // Verify email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Invalid email format',
            ];
        }
        
        // Check if user already exists
        $existingUser = $this->userModel->findByEmail($data['email']);
        if ($existingUser) {
            return [
                'success' => false,
                'message' => 'Email is already registered',
            ];
        }
        
        // Verify email with external service
        $verificationResult = $this->emailVerifier->verifyEmail($data['email']);
        
        if (!$verificationResult['success']) {
            return [
                'success' => false,
                'message' => $verificationResult['message'],
            ];
        }
        
        // Check if email has a score above 95
        if (isset($verificationResult['data']['overall_score']) && $verificationResult['data']['overall_score'] < 95) {
            return [
                'success' => false,
                'message' => 'Email verification failed. Please use a more reliable email address.',
            ];
        }
        
        // Prepare user data
        $userData = [
            'email' => $data['email'],
            'name' => $data['name'] ?? null,
        ];
        
        $authProvider = $data['auth_provider'] ?? 'email';
        $providerId = $data['provider_id'] ?? null;
        $password = $data['password'] ?? null;
        
        // Validate password if using email auth
        if ($authProvider === 'email' && !empty($password)) {
            if (strlen($password) < 8) {
                return [
                    'success' => false,
                    'message' => 'Password must be at least 8 characters long',
                ];
            }
            
            // Check for password confirmation if provided
            if (isset($data['password_confirm']) && $password !== $data['password_confirm']) {
                return [
                    'success' => false,
                    'message' => 'Passwords do not match',
                ];
            }
        }
        
        // Create user
        $userId = $this->userModel->create($userData, $authProvider, $providerId, $password);
        
        if (!$userId) {
            return [
                'success' => false,
                'message' => 'Registration failed. Please try again.',
            ];
        }
        
        // Set session for new user
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_email'] = $data['email'];
        $_SESSION['user_name'] = $data['name'] ?? null;
        
        return [
            'success' => true,
            'message' => 'Registration successful',
            'user_id' => $userId,
        ];
    }
    
    /**
     * Log in a user
     * 
     * @param array $data Login data
     * @return array Result with success status and message
     */
    public function login($data) {
        // Debug information
        error_log('Login attempt for email: ' . ($data['email'] ?? 'not provided'));
        
        // For email authentication
        if (($data['auth_provider'] ?? 'email') === 'email') {
            if (empty($data['email']) || empty($data['password'])) {
                return [
                    'success' => false,
                    'message' => 'Email and password are required',
                ];
            }
            
            // Verify email format first (basic check)
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Invalid email format',
                ];
            }
            
            // Check if user exists before verification (to avoid unnecessary API calls)
            $existingUser = $this->userModel->findByEmail($data['email']);
            if (!$existingUser) {
                return [
                    'success' => false,
                    'message' => 'Invalid email or password',
                ];
            }
            
            // TEMPORARILY DISABLED: Re-verify email with Reoon
            /*
            try {
                $verificationResult = $this->emailVerifier->verifyEmail($data['email']);
                
                // Log verification result for debugging
                error_log('Email verification result for ' . $data['email'] . ': ' . json_encode($verificationResult));
                
                // Check for critical issues that would prevent login
                if (!$verificationResult['success']) {
                    error_log('Email verification failed: ' . $verificationResult['message']);
                } elseif (isset($verificationResult['data']['is_deliverable']) && 
                         !$verificationResult['data']['is_deliverable']) {
                    // Log but don't block login - just for monitoring
                    error_log('Warning: Email may not be deliverable: ' . $data['email']);
                }
            } catch (Exception $e) {
                // Log error but don't block login if verification service fails
                error_log('Email verification service error: ' . $e->getMessage());
            }
            */
            
            // Verify password
            $user = $this->userModel->verifyPassword($data['email'], $data['password']);
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Invalid email or password',
                ];
            }
        } 
        // For OAuth providers (Google, Spotify)
        else {
            $provider = $data['auth_provider'];
            $providerId = $data['provider_id'];
            
            if (empty($provider) || empty($providerId)) {
                return [
                    'success' => false,
                    'message' => 'Invalid authentication data',
                ];
            }
            
            $user = $this->userModel->findByProviderId($provider, $providerId);
            
            // If user doesn't exist with this provider ID, but email exists
            if (!$user && !empty($data['email'])) {
                $user = $this->userModel->findByEmail($data['email']);
                
                // If email exists but with different auth method, link the accounts
                if ($user) {
                    // Update user's auth provider info (linking accounts)
                    // This would need an additional method in the User model
                }
                // If user doesn't exist at all, register them
                else {
                    return $this->register($data);
                }
            }
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Authentication failed',
                ];
            }
        }
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        
        error_log('Login successful for: ' . $user['email']);
        
        return [
            'success' => true,
            'message' => 'Login successful',
            'user_id' => $user['id'],
        ];
    }
    
    /**
     * Log out the current user
     * 
     * @return array Result with success status and message
     */
    public function logout() {
        // Clear session
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        session_destroy();
        
        return [
            'success' => true,
            'message' => 'Logout successful',
        ];
    }
    
    /**
     * Check if user is logged in
     * 
     * @return bool True if logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Get current user data
     * 
     * @return array|null User data or null if not logged in
     */
    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['user_name'],
        ];
    }
}