<?php
// Start session
session_start();

// Define base path
define('BASE_PATH', dirname(__DIR__));

// Initialize error logging
ini_set('log_errors', 1);
ini_set('error_log', BASE_PATH . '/storage/logs/app.log');

// Make sure log directory exists
if (!is_dir(BASE_PATH . '/storage/logs')) {
    mkdir(BASE_PATH . '/storage/logs', 0755, true);
}

// Set error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload classes (simple autoloader)
spl_autoload_register(function ($className) {
    $possiblePaths = [
        BASE_PATH . '/app/controllers/' . $className . '.php',
        BASE_PATH . '/app/models/' . $className . '.php',
        BASE_PATH . '/app/services/' . $className . '.php',
    ];

    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Simple router
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Initialize auth controller for use across routes
$authController = new AuthController();

// Route definitions
switch (true) {
    // Home page
    case $requestUri === '/' || $requestUri === '/index.php':
        require BASE_PATH . '/app/views/home.php';
        break;

    // User routes
    case $requestUri === '/login' && $method === 'GET':
        require BASE_PATH . '/app/views/auth/login.php';
        break;

    case $requestUri === '/register' && $method === 'GET':
        require BASE_PATH . '/app/views/auth/register.php';
        break;

    case $requestUri === '/login' && $method === 'POST':
        // Process login
        $data = [
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'auth_provider' => $_POST['auth_provider'] ?? 'email',
            'provider_id' => $_POST['provider_id'] ?? null,
        ];

        error_log('Login POST request received for: ' . $data['email']);
        
        try {
            $result = $authController->login($data);
            
            error_log('Login result: ' . json_encode($result));
            
            if ($result['success']) {
                error_log('Redirecting to dashboard after successful login');
                header('Location: /dashboard');
                exit;
            } else {
                error_log('Login failed: ' . $result['message']);
                $_SESSION['error'] = $result['message'];
                header('Location: /login');
                exit;
            }
        } catch (Exception $e) {
            error_log('Exception during login: ' . $e->getMessage());
            $_SESSION['error'] = 'An unexpected error occurred. Please try again.';
            header('Location: /login');
            exit;
        }
        break;

    case $requestUri === '/register' && $method === 'POST':
        // Process registration
        $data = [
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'name' => $_POST['name'] ?? '',
            'auth_provider' => $_POST['auth_provider'] ?? 'email',
            'provider_id' => $_POST['provider_id'] ?? null,
        ];

        error_log('Registration POST request received for: ' . $data['email']);

        try {
            $result = $authController->register($data);
            
            error_log('Registration result: ' . json_encode($result));
            
            if ($result['success']) {
                error_log('Redirecting to dashboard after successful registration');
                header('Location: /dashboard');
                exit;
            } else {
                error_log('Registration failed: ' . $result['message']);
                $_SESSION['error'] = $result['message'];
                header('Location: /register');
                exit;
            }
        } catch (Exception $e) {
            error_log('Exception during registration: ' . $e->getMessage());
            $_SESSION['error'] = 'An unexpected error occurred. Please try again.';
            header('Location: /register');
            exit;
        }
        break;

    case $requestUri === '/logout':
        $authController->logout();
        header('Location: /');
        exit;
        break;

    // Dashboard routes
    case $requestUri === '/dashboard' && $authController->isLoggedIn():
        try {
            $smartLinkController = new SmartLinkController();
            $links = $smartLinkController->getUserSmartLinks();
            include BASE_PATH . '/app/views/dashboard/index.php';
        } catch (Exception $e) {
            error_log('Exception loading dashboard: ' . $e->getMessage());
            $_SESSION['error'] = 'Error loading dashboard. Please try again.';
            include BASE_PATH . '/app/views/dashboard/index.php';
        }
        break;

    case $requestUri === '/dashboard/create' && $authController->isLoggedIn():
        include BASE_PATH . '/app/views/dashboard/create.php';
        break;

    case $requestUri === '/dashboard/create' && $method === 'POST' && $authController->isLoggedIn():
        $smartLinkController = new SmartLinkController();

        // Debug: Log the POST data
        error_log('Smart Link creation - POST data: ' . json_encode($_POST));
        
        // Process platform links if submitted
        $platformLinks = [];
        if (isset($_POST['platform']) && is_array($_POST['platform'])) {
            foreach ($_POST['platform'] as $i => $platformId) {
                if (!empty($platformId) && isset($_POST['platform_url'][$i]) && !empty($_POST['platform_url'][$i])) {
                    $platformLinks[] = [
                        'platform_id' => $platformId,
                        'platform_url' => $_POST['platform_url'][$i],
                    ];
                }
            }
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'spotify_url' => $_POST['spotify_url'] ?? '',
            'artwork_url' => $_POST['artwork_url'] ?? null,
            'artist_name' => $_POST['artist_name'] ?? null,
            'track_name' => $_POST['track_name'] ?? null,
            'platform_links' => $platformLinks,
        ];
        
        // Debug: Log the processed data
        error_log('Smart Link creation - Processed data: ' . json_encode($data));
        
        try {
            $result = $smartLinkController->createSmartLink($data);
            
            // Debug: Log the creation result
            error_log('Smart Link creation - Result: ' . json_encode($result));

            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: /dashboard');
                exit;
            } else {
                error_log('Smart Link creation - Error: ' . $result['message']);
                $_SESSION['error'] = $result['message'];
                // Store form data in session to repopulate the form
                $_SESSION['form_data'] = $data;
                header('Location: /dashboard/create');
                exit;
            }
        } catch (Exception $e) {
            // Debug: Log any exceptions
            error_log('Smart Link creation - Exception: ' . $e->getMessage());
            $_SESSION['error'] = 'An unexpected error occurred. Please try again.';
            $_SESSION['form_data'] = $data;
            header('Location: /dashboard/create');
            exit;
        }
        break;

    // Smart link public page
    case preg_match('/^\/link\/([a-z0-9-]+)$/', $requestUri, $matches):
        $slug = $matches[1];
        $smartLinkController = new SmartLinkController();
        
        try {
            $result = $smartLinkController->getSmartLinkBySlug($slug);

            if ($result['success']) {
                $smartLink = $result['data']['smart_link'];
                $platformLinks = $result['data']['platform_links'];
                include BASE_PATH . '/app/views/link.php';
            } else {
                error_log('Smart link not found: ' . $slug);
                http_response_code(404);
                include BASE_PATH . '/app/views/errors/404.php';
            }
        } catch (Exception $e) {
            error_log('Exception loading smart link: ' . $e->getMessage());
            http_response_code(404);
            include BASE_PATH . '/app/views/errors/404.php';
        }
        break;

    // Track platform click
    case preg_match('/^\/click\/([0-9]+)\/([0-9]+)$/', $requestUri, $matches):
        $smartLinkId = $matches[1];
        $platformId = $matches[2];

        try {
            $smartLinkController = new SmartLinkController();
            $smartLinkController->trackPlatformClick($smartLinkId, $platformId);

            // Get the platform URL to redirect to
            $smartLink = $smartLinkController->smartLinkModel->findById($smartLinkId);
            $platformLinks = $smartLinkController->smartLinkModel->getPlatformLinks($smartLinkId);

            $redirectUrl = '';
            foreach ($platformLinks as $link) {
                if ($link['platform_id'] == $platformId) {
                    $redirectUrl = $link['platform_url'];
                    break;
                }
            }

            if (!empty($redirectUrl)) {
                header("Location: $redirectUrl");
                exit;
            } else {
                header("Location: /link/{$smartLink['slug']}");
                exit;
            }
        } catch (Exception $e) {
            error_log('Exception tracking platform click: ' . $e->getMessage());
            // Redirect to home page if there's an error
            header('Location: /');
            exit;
        }
        break;

    // OAuth callback routes
    case $requestUri === '/auth/google/callback':
        // Process Google OAuth callback
        // This would be implemented with Google OAuth library
        break;

    case $requestUri === '/auth/spotify/callback':
        // Process Spotify OAuth callback
        // This would be implemented with Spotify OAuth library
        break;

    // API routes (for AJAX requests)
    case preg_match('/^\/api\/(.*)$/', $requestUri, $matches):
        header('Content-Type: application/json');

        $apiPath = $matches[1];

        switch ($apiPath) {
            case 'extract-metadata':
                $spotifyUrl = $_POST['spotify_url'] ?? '';
                try {
                    $spotifyService = new SpotifyService();
                    $metadata = $spotifyService->extractMetadata($spotifyUrl);

                    echo json_encode([
                        'success' => (bool) $metadata,
                        'data' => $metadata,
                    ]);
                } catch (Exception $e) {
                    error_log('Exception extracting metadata: ' . $e->getMessage());
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error extracting metadata. Please try again.',
                    ]);
                }
                break;
                
            case 'find-matching-links':
                $spotifyUrl = $_POST['spotify_url'] ?? '';
                try {
                    $musicPlatformService = new MusicPlatformService();
                    $result = $musicPlatformService->findMatchingLinks($spotifyUrl);
                    echo json_encode($result);
                } catch (Exception $e) {
                    error_log('Exception finding matching links: ' . $e->getMessage());
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error finding matching links. Please try again.',
                    ]);
                }
                break;

            case 'verify-email':
                $email = $_POST['email'] ?? '';
                try {
                    $emailVerifier = new EmailVerificationService();
                    $result = $emailVerifier->verifyEmail($email);
                    echo json_encode($result);
                } catch (Exception $e) {
                    error_log('Exception verifying email: ' . $e->getMessage());
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error verifying email. Please try again.',
                    ]);
                }
                break;

            case 'smart-links':
                if (!$authController->isLoggedIn()) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Authentication required',
                    ]);
                    break;
                }

                try {
                    $smartLinkController = new SmartLinkController();
                    $result = $smartLinkController->getUserSmartLinks();
                    echo json_encode($result);
                } catch (Exception $e) {
                    error_log('Exception getting smart links: ' . $e->getMessage());
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error retrieving smart links. Please try again.',
                    ]);
                }
                break;

            case 'delete-smart-link':
                if (!$authController->isLoggedIn()) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Authentication required',
                    ]);
                    break;
                }

                $id = $_POST['id'] ?? 0;
                try {
                    $smartLinkController = new SmartLinkController();
                    $result = $smartLinkController->deleteSmartLink($id);
                    echo json_encode($result);
                } catch (Exception $e) {
                    error_log('Exception deleting smart link: ' . $e->getMessage());
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error deleting smart link. Please try again.',
                    ]);
                }
                break;

            default:
                echo json_encode([
                    'success' => false,
                    'message' => 'API endpoint not found',
                ]);
                break;
        }
        break;

    // Default - 404 page
    default:
        http_response_code(404);
        include BASE_PATH . '/app/views/errors/404.php';
        break;
}