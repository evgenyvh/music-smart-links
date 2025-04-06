<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($smartLink['title']) ?> - Listen Now</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #5d3fd3;
            --secondary-color: #ff4b78;
            --dark-color: #1e1e2e;
            --light-color: #ffffff;
            --gray-color: #f5f6f8;
            --text-color: #333333;
            
            --primary-gradient: linear-gradient(135deg, #5d3fd3 0%, #8557f9 100%);
            --secondary-gradient: linear-gradient(135deg, #ff4b78 0%, #ff7964 100%);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            margin: 0;
            background-color: rgba(0, 0, 0, 0.8);
            background-size: cover;
            background-position: center;
            background-blend-mode: multiply;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: stretch;
            color: var(--light-color);
        }
        
        .music-link-container {
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        
        .artwork-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 24px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .artwork-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .artwork-container:hover .play-button {
            opacity: 1;
        }
        
        .play-icon {
            width: 24px;
            height: 24px;
            fill: var(--light-color);
        }
        
        .music-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .artist-name {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 32px;
            opacity: 0.8;
        }
        
        .platform-text {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
            opacity: 0.7;
        }
        
        .platform-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 40px;
        }
        
        .platform-button {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            background-color: var(--light-color);
            border-radius: 8px;
            color: var(--text-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .platform-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .platform-icon {
            width: 24px;
            height: 24px;
            margin-right: 16px;
        }
        
        .platform-button.spotify {
            color: #1DB954;
        }
        
        .platform-button.apple {
            color: #FA243C;
        }
        
        .platform-button.youtube {
            color: #FF0000;
        }
        
        .platform-button.tidal {
            color: #000000;
        }
        
        .platform-button.deezer {
            color: #FF0092;
        }
        
        .footer-branding {
            margin-top: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
            opacity: 0.7;
        }
        
        .footer-logo {
            font-weight: 700;
            margin-bottom: 4px;
        }
        
        .social-links {
            display: flex;
            gap: 24px;
            margin-top: 24px;
        }
        
        .social-link {
            color: var(--light-color);
            text-decoration: none;
            font-size: 14px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .social-link:hover {
            opacity: 1;
        }
        
        .animated-gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            opacity: 0.8;
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .loading-animation {
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 576px) {
            .music-link-container {
                padding: 16px;
            }
            
            .music-title {
                font-size: 24px;
            }
            
            .artist-name {
                font-size: 16px;
            }
        }
    </style>
    
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
</head>
<body class="loading-animation">
    <?php
    // Set background with artwork if available
    if (!empty($smartLink['artwork_url'])) {
        echo '<style>body { background-image: url("' . htmlspecialchars($smartLink['artwork_url']) . '"); }</style>';
    } else {
        // Use animated gradient if no artwork
        echo '<div class="animated-gradient-bg"></div>';
    }
    ?>
    
    <main class="d-flex flex-column min-vh-100">
        <div class="music-link-container mt-5">
            <div class="artwork-container">
                <?php if (!empty($smartLink['artwork_url'])): ?>
                    <img src="<?= htmlspecialchars($smartLink['artwork_url']) ?>" alt="<?= htmlspecialchars($smartLink['title']) ?>" class="artwork-img">
                <?php else: ?>
                    <div class="artwork-img bg-dark d-flex align-items-center justify-content-center">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 18V5L21 3V16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="6" cy="18" r="3" stroke="white" stroke-width="2"/>
                            <circle cx="18" cy="16" r="3" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <div class="play-button">
                    <svg class="play-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="5,3 19,12 5,21" fill="currentColor"/>
                    </svg>
                </div>
            </div>
            
            <h1 class="music-title"><?= htmlspecialchars($smartLink['title']) ?></h1>
            
            <?php if (!empty($smartLink['artist_name'])): ?>
                <h2 class="artist-name"><?= htmlspecialchars($smartLink['artist_name']) ?></h2>
            <?php endif; ?>
            
            <p class="platform-text">Choose your preferred music service:</p>
            
            <div class="platform-links">
                <?php foreach ($platformLinks as $platform): ?>
                    <?php
                    // Determine the platform-specific class and icon
                    $platformClass = '';
                    $platformIcon = '';
                    
                    if (stripos($platform['name'], 'spotify') !== false) {
                        $platformClass = 'spotify';
                        $platformIcon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>';
                    } elseif (stripos($platform['name'], 'apple') !== false) {
                        $platformClass = 'apple';
                        $platformIcon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.997 6.124a9.23 9.23 0 00-.24-2.19c-.317-1.31-1.062-2.31-2.18-3.043a5.022 5.022 0 00-.574-.324 5.032 5.032 0 00-2.682-.308c-.865.093-1.673.3-2.393.677a7.887 7.887 0 00-.748.42 8.205 8.205 0 00-1.626 1.306c-.26.272-.51.56-.74.868a9.104 9.104 0 00-.933 1.596 11.931 11.931 0 00-1.216-.332 10.31 10.31 0 00-2.548-.31c-1.593 0-3.343.53-4.87 1.475A8.128 8.128 0 00.637 9.36a8.61 8.61 0 00-.317.406 10.247 10.247 0 00-1.2 2.098 11.72 11.72 0 00-.63 1.832 13.632 13.632 0 00-.484 2.935c-.02.396-.02.773.03 1.188a8.35 8.35 0 00.102.782c.084.477.197.938.317 1.347a12.435 12.435 0 002.1 4.048c.262.386.566.753.856 1.086A8.646 8.646 0 004.176 27h15.647a8.646 8.646 0 002.766-1.87c.29-.332.595-.7.856-1.085a12.437 12.437 0 002.1-4.048c.12-.409.234-.87.317-1.347a8.079 8.079 0 00.102-.782c.05-.415.05-.792.03-1.188a13.633 13.633 0 00-.484-2.935 11.72 11.72 0 00-.63-1.832 10.247 10.247 0 00-1.2-2.098zm-10.998 9.818l-1.429-4.354 3.777 3.256-.944.33-1.404.77zm9.166-5.839c-.172.486-.484 1.013-.889 1.493-.401.474-.79.796-1.117.991v3.516h-2.515l-.5-8.601 2.748 4.51-.429 1.03.398.032c.213.015.308.015.417.015a.654.654 0 00.318-.08.934.934 0 00.3-.245c.104-.124.225-.339.3-.507.028-.064.046-.13.069-.201H23.18c-.1.705-.525 1.434-.943 1.936-.4.484-.792.83-1.156 1.029v.999h-2.511v-1.307c-.363-.197-.752-.531-1.156-1.029-.379-.461-.78-1.077-.919-1.692h-.08a1.402 1.402 0 01-.067.2.916.916 0 01-.3.508.656.656 0 01-.3.245.672.672 0 01-.318.079 2.892 2.892 0 01-.415-.032l-.401-.03-.427-1.027 2.748-4.51-.5 8.6h-2.514v-3.515c-.327-.195-.713-.517-1.117-.99-.404-.484-.715-1.013-.889-1.494a4.269 4.269 0 01-.192-.577c.522 0 1.045-.03 1.568-.092a8.798 8.798 0 001.42-.283c.461-.145.89-.328 1.24-.56.342-.218.619-.477.826-.752.203-.263.343-.556.412-.869.075-.328.091-.67.046-1.045h2.016c-.055.376-.03.717.047 1.045.062.312.203.607.403.87.203.273.486.533.826.751.342.233.782.416 1.24.56.464.146.904.238 1.42.284.522.06 1.043.092 1.568.092-.035.18-.096.371-.191.575z"/></svg>';
                    } elseif (stripos($platform['name'], 'youtube') !== false) {
                        $platformClass = 'youtube';
                        $platformIcon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
                    } elseif (stripos($platform['name'], 'tidal') !== false) {
                        $platformClass = 'tidal';
                        $platformIcon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12.012 3.992L8.008 7.996 4.004 3.992 0 7.996 4.004 12l4.004-4.004L12.012 12l-4.004 4.004L12.012 20l4.004-4.004L20.02 20l3.972-4.004L20.02 12l-4.004 4.004L12.012 12l4.004-4.004-4.004-4.004z"/></svg>';
                    } elseif (stripos($platform['name'], 'deezer') !== false) {
                        $platformClass = 'deezer';
                        $platformIcon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.81 4.16v3.03H24V4.16m-18.818 0v3.03h5.197V4.16m-5.197 4.57v3.03h5.189V8.73m12.627 0v3.03H24V8.73m-12.62 0v3.03h5.195V8.73M0 13.35v3.022h5.189v-3.03m6.315 0v3.022h5.195v-3.03m6.308 0v3.022H24v-3.03m-18.81 4.56v3.03h5.189v-3.03m6.315 0v3.03h5.195v-3.03"/></svg>';
                    } else {
                        // Generic music icon for other platforms
                        $platformIcon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>';
                    }
                    ?>
                    <a href="/click/<?= $smartLink['id'] ?>/<?= $platform['platform_id'] ?>" target="_blank" class="platform-button <?= $platformClass ?>">
                        <span class="platform-icon"><?= $platformIcon ?></span>
                        <span class="platform-name"><?= htmlspecialchars($platform['name']) ?></span>
                    </a>
                <?php endforeach; ?>
                
                <?php if (empty($platformLinks)): ?>
                    <div class="text-center p-4">
                        <p>No streaming links available yet.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="social-links">
                <a href="#" class="social-link">Instagram</a>
                <a href="#" class="social-link">Twitter</a>
                <a href="#" class="social-link">Facebook</a>
            </div>
        </div>
        
        <div class="footer-branding mt-auto mb-3">
            <div class="footer-logo">Powered by</div>
            <a href="/" class="text-light">Music Smart Links</a>
        </div>
    </main>
    
    <script>
        // Simple loading animation effect
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('loaded');
            
            // Add play button functionality
            const playButton = document.querySelector('.play-button');
            if (playButton) {
                playButton.addEventListener('click', function() {
                    // You could add preview functionality here
                    // For now, just click the first platform link
                    const firstPlatformLink = document.querySelector('.platform-button');
                    if (firstPlatformLink) {
                        firstPlatformLink.click();
                    }
                });
            }
        });
    </script>
</body>
</html>