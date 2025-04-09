<?php
// Start session
session_start();

// Set error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path
define('BASE_PATH', dirname(__DIR__));

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

        $result = $authController->login($data);

        if ($result['success']) {
            header('Location: /dashboard');
            exit;
        } else {
            $_SESSION['error'] = $result['message'];
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

        $result = $authController->register($data);

        if ($result['success']) {
            header('Location: /dashboard');
            exit;
        } else {
            $_SESSION['error'] = $result['message'];
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
        $smartLinkController = new SmartLinkController();
        $links = $smartLinkController->getUserSmartLinks();
        require BASE_PATH . '/app/views/dashboard/index.php';
        break;

    case $requestUri === '/dashboard/create' && $authController->isLoggedIn():
        require BASE_PATH . '/app/views/dashboard/create.php';
        break;

    case $requestUri === '/dashboard/create' && $method === 'POST' && $authController->isLoggedIn():
        $smartLinkController = new SmartLinkController();

        // Debug: Log the POST data
        error_log('POST data: ' . json_encode($_POST));
        // Process platform links if submitted
        $platformLinks = [];
        if (isset($_POST['platform']) && is_array($_POST['platform'])) {
            foreach ($_POST['platform'] as $i => $platformId) {
                if (!empty($_POST['platform_url'][$i])) {
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
        $result = $smartLinkController->createSmartLink($data);

        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
            header('Location: /dashboard');
            exit;
        } else {
            $_SESSION['error'] = $result['message'];
            // Store form data in session to repopulate the form
            $_SESSION['form_data'] = $data;
            header('Location: /dashboard/create');
            exit;
        }
        break;

    // Smart link public page
    case preg_match('/^\/link\/([a-z0-9-]+)$/', $requestUri, $matches):
        $slug = $matches[1];
        $smartLinkController = new SmartLinkController();
        $result = $smartLinkController->getSmartLinkBySlug($slug);

        if ($result['success']) {
            $smartLink = $result['data']['smart_link'];
            $platformLinks = $result['data']['platform_links'];
            require BASE_PATH . '/app/views/link.php';
        } else {
            http_response_code(404);
            require BASE_PATH . '/app/views/errors/404.php';
        }
        break;

    // Track platform click
    case preg_match('/^\/click\/([0-9]+)\/([0-9]+)$/', $requestUri, $matches):
        $smartLinkId = $matches[1];
        $platformId = $matches[2];

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
                $spotifyService = new SpotifyService();
                $metadata = $spotifyService->extractMetadata($spotifyUrl);

                echo json_encode([
                    'success' => (bool) $metadata,
                    'data' => $metadata,
                ]);
                break;
                
                case 'find-matching-links':
                    $spotifyUrl = $_POST['spotify_url'] ?? '';
                    $musicPlatformService = new MusicPlatformService();
                    $result = $musicPlatformService->findMatchingLinks($spotifyUrl);
            
                    echo json_encode($result);
                    break;
            
            case 'verify-email':
                $email = $_POST['email'] ?? '';
                $emailVerifier = new EmailVerificationService();
                $result = $emailVerifier->verifyEmail($email);

                echo json_encode($result);
                break;

            case 'smart-links':
                if (!$authController->isLoggedIn()) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Authentication required',
                    ]);
                    break;
                }

                $smartLinkController = new SmartLinkController();
                $result = $smartLinkController->getUserSmartLinks();

                echo json_encode($result);
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
                $smartLinkController = new SmartLinkController();
                $result = $smartLinkController->deleteSmartLink($id);

                echo json_encode($result);
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
        require BASE_PATH . '/app/views/errors/404.php';
        break;
}