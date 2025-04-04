<?php
$pageTitle = 'Dashboard - Music Smart Links';
ob_start();

// Get current user data
$currentUser = $authController->getCurrentUser();

// Get links data from the controller
$userLinks = isset($links['data']) ? $links['data'] : [];

// Get config for free tier limit
$config = require BASE_PATH . '/config/app.php';
$maxLinks = $config['free_tier']['max_links'];
?>

<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Welcome, <?= htmlspecialchars($currentUser['name'] ?? 'Artist') ?></h1>
            <p class="text-gray-600">Manage your smart links and view analytics</p>
        </div>
        
        <div class="mt-4 md:mt-0">
            <?php if (count($userLinks) < $maxLinks): ?>
                <a href="/dashboard/create" class="bg-indigo-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                    Create New Link
                </a>
            <?php else: ?>
                <div class="flex items-center">
                    <span class="text-orange-600 mr-3">Free tier limit reached (<?= $maxLinks ?> links)</span>
                    <a href="/upgrade" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold px-4 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-300">
                        Upgrade
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (empty($userLinks)): ?>
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <div class="text-gray-400 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>
        <h2 class="text-xl font-bold mb-2">No Smart Links Yet</h2>
        <p class="text-gray-600 mb-6">Create your first smart link to start promoting your music.</p>
        <a href="/dashboard/create" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
            Create Your First Link
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($userLinks as $link): ?>
            <?php 
                $smartLink = $link['smart_link'];
                $platformLinks = $link['platform_links'];
                $analytics = $link['analytics'];
                
                // Generate the public link URL
                $linkUrl = '/link/' . $smartLink['slug'];
                
                // Get counts
                $pageViews = $analytics['page_views'] ?? 0;
                $platformClicks = $analytics['platform_clicks'] ?? [];
                $totalClicks = array_sum(array_column($platformClicks, 'click_count'));
            ?>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    <?php if (!empty($smartLink['artwork_url'])): ?>
                        <img src="<?= htmlspecialchars($smartLink['artwork_url']) ?>" alt="<?= htmlspecialchars($smartLink['title']) ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center">
                            <span class="text-white text-2xl font-bold"><?= htmlspecialchars($smartLink['title']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute top-2 right-2">
                        <div class="flex space-x-2">
                            <button onclick="copyToClipboard('<?= $linkUrl ?>')" class="bg-gray-800 bg-opacity-70 text-white p-2 rounded-full hover:bg-opacity-100 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                            <a href="<?= $linkUrl ?>" target="_blank" class="bg-gray-800 bg-opacity-70 text-white p-2 rounded-full hover:bg-opacity-100 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-1"><?= htmlspecialchars($smartLink['title']) ?></h2>
                    
                    <?php if (!empty($smartLink['artist_name'])): ?>
                        <p class="text-gray-600 mb-2"><?= htmlspecialchars($smartLink['artist_name']) ?></p>
                    <?php endif; ?>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <span class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <?= number_format($pageViews) ?> views
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <?= number_format($totalClicks) ?> clicks
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach ($platformLinks as $platform): ?>
                            <div class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                                <?= htmlspecialchars($platform['name']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                        <span class="text-sm text-gray-600">
                            Created <?= date('M j, Y', strtotime($smartLink['created_at'])) ?>
                        </span>
                        
                        <div class="flex space-x-2">
                            <a href="/dashboard/edit/<?= $smartLink['id'] ?>" class="text-indigo-600 hover:text-indigo-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button onclick="deleteSmartLink(<?= $smartLink['id'] ?>)" class="text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
function copyToClipboard(text) {
    // Create a temporary input element
    const input = document.createElement('input');
    input.setAttribute('value', window.location.origin + text);
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);
    
    // Show a notification (you would implement this)
    alert('Link copied to clipboard!');
}

function deleteSmartLink(id) {
    if (confirm('Are you sure you want to delete this smart link? This action cannot be undone.')) {
        // Send AJAX request to delete the link
        fetch('/api/delete-smart-link', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to show the updated list
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the smart link.');
        });
    }
}
</script>

<?php
$content = ob_get_clean();
include BASE_PATH . '/app/views/layout.php';
