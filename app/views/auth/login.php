<?php
$pageTitle = 'Login - Music Smart Links';
ob_start();
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h1 class="text-2xl font-bold text-center mb-6">Log In to Your Account</h1>
    
    <form action="/login" method="POST" class="space-y-4">
        <div>
            <label for="email" class="block text-gray-700 mb-1">Email Address</label>
            <input type="email" id="email" name="email" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        
        <div>
            <label for="password" class="block text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
            </div>
            
            <a href="/forgot-password" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
        </div>
        
        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                Log In
            </button>
        </div>
    </form>
    
    <div class="mt-6 border-t border-gray-200 pt-4">
        <p class="text-center text-gray-600 mb-4">Or log in with</p>
        
        <div class="grid grid-cols-2 gap-4">
            <a href="/auth/google" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z" fill="#4285F4"/>
                </svg>
                Google
            </a>
            
            <a href="/auth/spotify" class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z" fill="#1DB954"/>
                </svg>
                Spotify
            </a>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <p class="text-gray-600">
            Don't have an account? <a href="/register" class="text-indigo-600 hover:underline">Sign up</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layout.php';
