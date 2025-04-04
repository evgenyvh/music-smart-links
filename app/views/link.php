<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($smartLink['title']) ?> - Listen Now</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Open Graph Meta Tags for social sharing -->
    <meta property="og:title" content="<?= htmlspecialchars($smartLink['title']) ?> - Listen Now">
    <?php if (!empty($smartLink['artist_name'])): ?>
        <meta property="og:description" content="Listen to <?= htmlspecialchars($smartLink['title']) ?> by <?= htmlspecialchars($smartLink['artist_name']) ?> on your favorite platform.">
    <?php else: ?>
        <meta property="og:description" content="Listen to <?= htmlspecialchars($smartLink['title']) ?> on your favorite platform.">
    <?php endif; ?>
    <?php if (!empty($smartLink['artwork_url'])): ?>
        <meta property="og:image" content="<?= htmlspecialchars($smartLink['artwork_url']) ?>">
    <?php endif; ?>
    <meta property="og:url" content="<?= 'https://' . $_SERVER['HTTP_HOST'] . '/link/' . $smartLink['slug'] ?>">
    <meta property="og:type" content="music">
    
    <style>
        .loading-animation {
            animation: fadeIn 1s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .platform-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen">
    <?php
    // Determine background style (artwork or gradient)
    $bgStyle = '';
    $overlayOpacity = 'bg-opacity-80';
    
    if (!empty($smartLink['artwork_url'])) {
        $bgStyle = "background-image: url('" . htmlspecialchars($smartLink['artwork_url']) . "'); background-size: cover; background-position: center;";
    } else {
        $bgStyle = "background: linear-gradient(to right, #4f46e5, #7c3aed);";
        $overlayOpacity = 'bg-opacity-0';
    }
    ?>
    
    <div style="<?= $bgStyle ?>" class="min-h-screen relative">
        <!-- Overlay for better text visibility -->
        <div class="absolute inset-0 bg-black <?= $overlayOpacity ?>"></div>
        
        <!-- Content container -->
        <div class="relative z-10 min-h-screen flex flex-col items-center justify-center p-6 loading-animation">
            <div class="max-w-md w-full bg-white bg-opacity-90 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden">
                <!-- Header with artwork -->
                <div class="relative">
                    <?php if (!empty($smartLink['artwork_url'])): ?>
                        <img src="<?= htmlspecialchars($smartLink['artwork_url']) ?>" alt="<?= htmlspecialchars($smartLink['title']) ?>" class="w-full aspect-square object-cover">
                    <?php else: ?>
                        <div class="w-full aspect-square bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center">
                            <span class="text-white text-2xl font-bold"><?= htmlspecialchars($smartLink['title']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Track/Album info -->
                <div class="p-6 text-center">
                    <h1 class="text-2xl font-bold mb-1"><?= htmlspecialchars($smartLink['title']) ?></h1>
                    
                    <?php if (!empty($smartLink['artist_name'])): ?>
                        <p class="text-gray-600 mb-6"><?= htmlspecialchars($smartLink['artist_name']) ?></p>
                    <?php else: ?>
                        <div class="mb-6"></div>
                    <?php endif; ?>
                    
                    <!-- Platform buttons -->
                    <div class="space-y-3">
                        <?php foreach ($platformLinks as $platform): ?>
                            <a href="/click/<?= $smartLink['id'] ?>/<?= $platform['platform_id'] ?>" target="_blank" 
                                class="platform-button block w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg transition duration-300 flex items-center">
                                <span class="w-8 h-8 flex items-center justify-center mr-3">
                                    <!-- Replace with actual platform icons -->
                                    <?php if (strpos(strtolower($platform['name']), 'spotify') !== false): ?>
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">
                                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z" fill="#1DB954"/>
                                        </svg>
                                    <?php elseif (strpos(strtolower($platform['name']), 'apple') !== false): ?>
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">
                                            <path d="M23.997 6.124c0-.738-.065-1.47-.24-2.19-.317-1.31-1.062-2.31-2.18-3.043C21.003.517 20.373.285 19.7.164c-.517-.093-1.038-.135-1.564-.15-.04-.003-.083-.01-.124-.013H5.988c-.152.01-.303.017-.455.026C4.786.07 4.043.15 3.34.428 2.004.958 1.02 1.88.475 3.208c-.192.466-.3.956-.35 1.463-.024.243-.043.487-.052.73-.01.08-.01.157-.01.236v12.711c.01.07.01.147.02.227.022.553.07 1.1.183 1.638.32 1.521 1.093 2.738 2.363 3.608.594.4 1.24.666 1.912.864.472.135.953.218 1.438.262.16.016.32.033.48.04h13.304c.084 0 .168-.01.252-.01.551-.013 1.095-.071 1.629-.2.912-.232 1.73-.646 2.409-1.313.416-.414.744-.888.994-1.396.1-.174.656-1.28.656-1.28.29-.777.44-1.588.45-2.43v-12.33zM12.002 8.33l3.228 5.59h-2.096l-1.148-2-1.143 2H8.77l3.232-5.59z" fill="#FF3B30"/>
                                        </svg>
                                    <?php elseif (strpos(strtolower($platform['name']), 'youtube') !== false): ?>
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" fill="#FF0000"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                    <?php endif; ?>
                                </span>
                                <span class="font-medium">Listen on <?= htmlspecialchars($platform['name']) ?></span>
                            </a>
                        <?php endforeach; ?>
                        
                        <?php if (empty($platformLinks)): ?>
                            <div class="text-gray-600 text-center p-4">
                                <p>No streaming links available yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-6 text-center text-white text-sm">
                <p>Powered by <a href="/" class="font-bold hover:underline">Music Smart Links</a></p>
            </div>
        </div>
    </div>

    <script>
        // Add a small delay for the loading animation
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelector('.loading-animation').style.opacity = 1;
            }, 100);
        });
    </script>
</body>
</html>
