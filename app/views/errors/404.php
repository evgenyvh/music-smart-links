<?php
$pageTitle = '404 Not Found - JAE Smartlink';
ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 text-center">
            <div class="mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="180" height="180" fill="currentColor" class="text-dark mb-4" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                </svg>
            </div>
            
            <h1 class="display-4 fw-bold mb-4">404 - Page Not Found</h1>
            <p class="lead mb-5">The page you're looking for doesn't exist or has been moved.</p>
            
            <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                <a href="/" class="btn btn-primary px-4 py-2">Back to Home</a>
                <a href="/dashboard" class="btn btn-outline-dark px-4 py-2">Go to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include BASE_PATH . '/app/views/layout.php';
?>