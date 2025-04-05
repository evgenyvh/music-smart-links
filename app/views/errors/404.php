<?php
$pageTitle = '404 Not Found - Music Smart Links';
ob_start();
?>

<div class="flex flex-col items-center justify-center py-12">
    <div class="text-indigo-600 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
    
    <h1 class="text-4xl font-bold mb-4">404 - Page Not Found</h1>
    <p class="text-gray-600 text-center mb-8">The page you're looking for doesn't exist or has been moved.</p>
    
    <div class="flex space-x-4">
        <a href="/" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
            Go Home
        </a>
        <a href="/dashboard" class="bg-gray-200 text-gray-700 font-bold px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-300">
            Dashboard
        </a>
    </div>
</div>

<?php
$content = ob_get_clean();
include BASE_PATH . '/app/views/layout.php';