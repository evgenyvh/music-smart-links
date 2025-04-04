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
            return [
                'success' => false,
                'message' => 'Daily email verification limit exceeded',
                'data' => null
            ];
        }
        
        // Increment request count
        $this->incrementRequestCount();
        
        // Build the API URL
        $url = $this->apiUrl . '?email=' . urlencode($email) . '&key=' . $this->apiKey . '&mode=' . $this->mode;
        
        // Make the API request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            error_log('Error verifying email. HTTP code: ' . $httpCode);
            return [
                'success' => false,
                'message' => 'Email verification service error',
                'data' => null
            ];
        }
        
        $responseData = json_decode($response, true);
        
        if (!$responseData) {
            return [
                'success' => false,
                'message' => 'Invalid response from email verification service',
                'data' => null
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