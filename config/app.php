<?php

// Application configuration
return [
    // App settings
    'app_name' => 'Music Smart Links',
    'app_url' => 'http://localhost:8000', // Change for production
    
    // API Keys
    'spotify' => [
        'client_id' => '595d7acb03ee4480b23bb438edd7353c',
        'client_secret' => '3b311cdee54a4473bc3201c1829a34fe',
    ],
    
    'email_verification' => [
        'api_url' => 'https://emailverifier.reoon.com/api/v1/verify',
        'api_key' => '171YCVFGH3h0ZkFyRjZZjJuimTN2UdFq',
        'mode' => 'power',
        'daily_limit' => 400, // As per requirements
    ],
    
    // Auth settings
    'auth' => [
        'password_algorithm' => PASSWORD_DEFAULT,
        'session_timeout' => 86400, // 24 hours
    ],
    
    // Smart link settings
    'free_tier' => [
        'max_links' => 3,
        'analytics_retention_days' => 7,
    ],
    
    // Paid plan
    'paid_plan' => [
        'yearly_price' => 12, // $12 per year
    ],
];
