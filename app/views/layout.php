<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Music Smart Links' ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    
    <!-- Custom styles -->
    <style>
        .loading-animation {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="/" class="text-xl font-bold">Music Smart Links</a>
                
                <div class="flex space-x-4">
                    <?php if (isset($authController) && $authController->isLoggedIn()): ?>
                        <a href="/dashboard" class="hover:text-indigo-200">Dashboard</a>
                        <a href="/logout" class="hover:text-indigo-200">Logout</a>
                    <?php else: ?>
                        <a href="/login" class="hover:text-indigo-200">Login</a>
                        <a href="/register" class="hover:text-indigo-200">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Content -->
    <main class="container mx-auto px-4 py-8">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <?php include $content; ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p>&copy; <?= date('Y') ?> Music Smart Links</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/about" class="hover:text-indigo-300">About</a>
                    <a href="/privacy" class="hover:text-indigo-300">Privacy Policy</a>
                    <a href="/terms" class="hover:text-indigo-300">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
