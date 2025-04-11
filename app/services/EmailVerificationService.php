<?php

class EmailVerificationService {
    private $apiUrl;
    private $apiKey;
    private $mode;
    private $dailyLimit;
    private $requestCount;
    private $lastResetDate;
    
    public function __construct() {
        $config = require __DIR__ . '/../../config/app.php';
        $this->apiUrl = $config['email_verification']['api_url'];
        $this->apiKey = $config['email_verification']['api_key'];
        $this->mode = $config['email_verification']['mode'];
        $this->dailyLimit = $config['email_verification']['daily_limit'];
        
        // Initialize rate limiting
        $this->loadRequestCount();
    }
    
    /**
     * Load the current request count from storage
     */
    private function loadRequestCount() {
        $countFile = __DIR__ . '/../../storage/email_verification_count.json';
        
        if (!file_exists($countFile)) {
            $this->requestCount = 0;
            $this->lastResetDate = date('Y-m-d');
            $this->saveRequestCount();
            return;
        }
        
        $data = json_decode(file_get_contents($countFile), true);
        
        if ($data) {
            $this->requestCount = $data['count'];
            $this->lastResetDate = $data['date'];
            
            // Reset count if it's a new day
            $today = date('Y-m-d');
            if ($this->lastResetDate !== $today) {
                $this->requestCount = 0;
                $this->lastResetDate = $today;
                $this->saveRequestCount();
            }
        } else {
            $this->requestCount = 0;
            $this->lastResetDate = date('Y-m-d');
            $this->saveRequestCount();
        }
    }
    
    /**
     * Save the current request count to storage
     */
    private function saveRequestCount() {
        $countFile = __DIR__ . '/../../storage/email_verification_count.json';
        $data = [
            'count' => $this->requestCount,
            'date' => $this->lastResetDate
        ];
        
        // Ensure directory exists
        $dir = dirname($countFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents($countFile, json_encode($data));
    }
    
    /**
     * Verify an email address
     * 
     * @param string $email Email to verify
     * @return array Verification result
     */
    public function verifyEmail($email) {
        // Check rate limit
        if (!$this->checkRateLimit()) {
            error_log('Daily email verification limit exceeded: ' . $this->requestCount . '/' . $this->dailyLimit);
            return [
                'success' => false,
                'message' => 'Daily email verification limit exceeded',
                'data' => null
            ];
        }
        
        // Increment request count first to prevent race conditions
        $this->incrementRequestCount();
        
        // Build the API URL
        $url = $this->apiUrl . '?email=' . urlencode($email) . '&key=' . $this->apiKey . '&mode=' . $this->mode;
        
        // Make the API request with proper error handling
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Add timeout to prevent hanging
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'JAE Smartlink Email Verification');
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        // Log the response for debugging
        error_log('Email verification response for ' . $email . ': ' . substr($response, 0, 200) . (strlen($response) > 200 ? '...' : ''));
        
        if ($error) {
            error_log('Curl error verifying email: ' . $error);
            return [
                'success' => false,
                'message' => 'Email verification service connection error',
                'data' => null
            ];
        }
        
        if ($httpCode !== 200) {
            error_log('Error verifying email. HTTP code: ' . $httpCode);
            return [
                'success' => false,
                'message' => 'Email verification service error (HTTP ' . $httpCode . ')',
                'data' => null
            ];
        }
        
        $responseData = json_decode($response, true);
        
        if (!$responseData) {
            error_log('Invalid JSON response from email verification service');
            return [
                'success' => false,
                'message' => 'Invalid response from email verification service',
                'data' => null
            ];
        }
        
        // Check for risky email statuses
        if (isset($responseData['status']) && in_array($responseData['status'], [
            'invalid', 'disabled', 'disposable', 'inbox_full', 'catch_all', 'role_account', 'spamtrap'
        ])) {
            return [
                'success' => false,
                'message' => 'Email verification failed. This email appears to be ' . $responseData['status'] . '.',
                'data' => $responseData
            ];
        }
        
        // Return standardized format
        return [
            'success' => true,
            'message' => 'Email verification completed',
            'data' => $responseData
        ];
    }
    
    /**
     * Check if we're within the rate limit
     * 
     * @return bool True if within limit
     */
    private function checkRateLimit() {
        return $this->requestCount < $this->dailyLimit;
    }
    
    /**
     * Increment the request count
     */
    private function incrementRequestCount() {
        $this->requestCount++;
        $this->saveRequestCount();
    }
}