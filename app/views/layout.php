<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Music Smart Links' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/styles.css">
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">Music Smart Links</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#pricing">Pricing</a>
                    </li>
                    <?php if (isset($authController) && $authController->isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-3" href="/register">Get Started</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php 
        // Include the content
        if (isset($content)) {
            if (is_file($content)) {
                include $content;
            } else {
                echo $content;
            }
        }
        ?>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-logo">Music Smart Links</div>
                    <p>The modern way for artists to promote their music across all platforms with just one link.</p>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <div class="footer-links">
                        <h4>Solutions</h4>
                        <ul>
                            <li><a href="#">Artist Bio Links</a></li>
                            <li><a href="#">Pre-Release Links</a></li>
                            <li><a href="#">Release Links</a></li>
                            <li><a href="#">Tour and Event Links</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <div class="footer-links">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Help Center</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <div class="footer-links">
                        <h4>Stay Connected</h4>
                        <p>Subscribe to our newsletter for updates and tips.</p>
                        <form action="#" method="POST" class="mt-3">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Your email" aria-label="Your email">
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom text-center">
                <div class="row">
                    <div class="col-md-6 text-md-start">
                        <p>&copy; <?= date('Y') ?> Music Smart Links. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="/terms" class="me-3">Terms of Service</a>
                        <a href="/privacy" class="me-3">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>