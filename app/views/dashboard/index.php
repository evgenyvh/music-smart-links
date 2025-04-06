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

<div class="dashboard-container py-4">
    <!-- Dashboard Header -->
    <div class="dashboard-header mb-4 bg-white rounded-lg p-4 shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 mb-0">Welcome, <?= htmlspecialchars($currentUser['name'] ?? 'Artist') ?></h1>
                <p class="text-muted">Manage your smart links and view analytics</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <?php if (count($userLinks) < $maxLinks): ?>
                    <a href="/dashboard/create" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg me-2" viewBox="0 0 16 16">
                            <path d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"/>
                        </svg>
                        Create New Link
                    </a>
                <?php else: ?>
                    <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                        <span class="badge bg-warning text-dark">Free tier limit reached (<?= $maxLinks ?> links)</span>
                        <a href="/upgrade" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star me-2" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                            </svg>
                            Upgrade
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="mb-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="bg-white rounded-lg p-4 shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 mb-0">Total Links</h2>
                        <span class="badge bg-primary"><?= count($userLinks) ?> / <?= $maxLinks ?></span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <?php $percentage = (count($userLinks) / $maxLinks) * 100; ?>
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="bg-white rounded-lg p-4 shadow-sm h-100">
                    <h2 class="h5 mb-3">Total Views</h2>
                    <?php 
                        $totalViews = 0;
                        foreach ($userLinks as $link) {
                            $totalViews += $link['analytics']['page_views'] ?? 0;
                        }
                    ?>
                    <div class="h2 mb-0"><?= number_format($totalViews) ?></div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="bg-white rounded-lg p-4 shadow-sm h-100">
                    <h2 class="h5 mb-3">Total Clicks</h2>
                    <?php 
                        $totalClicks = 0;
                        foreach ($userLinks as $link) {
                            $platformClicks = $link['analytics']['platform_clicks'] ?? [];
                            $totalClicks += array_sum(array_column($platformClicks, 'click_count'));
                        }
                    ?>
                    <div class="h2 mb-0"><?= number_format($totalClicks) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Smart Links -->
    <h2 class="h4 mb-4">Your Smart Links</h2>
    
    <?php if (empty($userLinks)): ?>
        <div class="bg-white rounded-lg p-5 shadow-sm text-center">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-link-45deg text-muted" viewBox="0 0 16 16">
                    <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                    <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                </svg>
            </div>
            <h3 class="h5 mb-3">No Smart Links Yet</h3>
            <p class="text-muted mb-4">Create your first smart link to start promoting your music.</p>
            <a href="/dashboard/create" class="btn btn-primary">
                Create Your First Link
            </a>
        </div>
    <?php else: ?>
        <div class="row">
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
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <?php if (!empty($smartLink['artwork_url'])): ?>
                                <img src="<?= htmlspecialchars($smartLink['artwork_url']) ?>" alt="<?= htmlspecialchars($smartLink['title']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <span class="h3"><?= htmlspecialchars($smartLink['title']) ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="position-absolute top-0 end-0 p-2">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="<?= $linkUrl ?>" target="_blank">Open Link</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('<?= $linkUrl ?>')">Copy Link</a></li>
                                        <li><a class="dropdown-item" href="/dashboard/edit/<?= $smartLink['id'] ?>">Edit Link</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteSmartLink(<?= $smartLink['id'] ?>)">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <h3 class="h5 card-title mb-1"><?= htmlspecialchars($smartLink['title']) ?></h3>
                            <?php if (!empty($smartLink['artist_name'])): ?>
                                <p class="text-muted mb-3"><?= htmlspecialchars($smartLink['artist_name']) ?></p>
                            <?php endif; ?>
                            
                            <div class="d-flex mb-3">
                                <div class="me-4">
                                    <small class="text-muted d-block">Views</small>
                                    <span class="fw-bold"><?= number_format($pageViews) ?></span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Clicks</small>
                                    <span class="fw-bold"><?= number_format($totalClicks) ?></span>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <?php foreach ($platformLinks as $platform): ?>
                                    <span class="badge bg-light text-dark"><?= htmlspecialchars($platform['name']) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <small class="text-muted">Created <?= date('M j, Y', strtotime($smartLink['created_at'])) ?></small>
                            <div>
                                <a href="/dashboard/edit/<?= $smartLink['id'] ?>" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                <a href="<?= $linkUrl ?>" target="_blank" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function copyToClipboard(text) {
    const domain = window.location.origin;
    const fullUrl = domain + text;
    
    navigator.clipboard.writeText(fullUrl).then(() => {
        // Create toast notification
        const toastContainer = document.createElement('div');
        toastContainer.style.position = 'fixed';
        toastContainer.style.bottom = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '1050';
        
        const toast = document.createElement('div');
        toast.className = 'toast show';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto">Music Smart Links</strong>
                <button type="button" class="btn-close" onclick="this.parentElement.parentElement.parentElement.remove()"></button>
            </div>
            <div class="toast-body">
                Link copied to clipboard!
            </div>
        `;
        
        toastContainer.appendChild(toast);
        document.body.appendChild(toastContainer);
        
        // Remove toast after 3 seconds
        setTimeout(() => {
            toastContainer.remove();
        }, 3000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
        alert('Failed to copy link to clipboard. Please try again.');
    });
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
?>