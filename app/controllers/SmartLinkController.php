<?php

require_once __DIR__ . '/../models/SmartLink.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Analytics.php';
require_once __DIR__ . '/../services/SpotifyService.php';
require_once __DIR__ . '/AuthController.php';

class SmartLinkController {
    private $smartLinkModel;
    private $userModel;
    private $analyticsModel;
    private $spotifyService;
    private $authController;
    
    public function __construct() {
        $this->smartLinkModel = new SmartLink();
        $this->userModel = new User();
        $this->analyticsModel = new Analytics();
        $this->spotifyService = new SpotifyService();
        $this->authController = new AuthController();
    }
    
    /**
     * Create a new smart link
     * 
     * @param array $data Smart link data
     * @return array Result with success status and message
     */
    public function createSmartLink($data) {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to create a smart link',
            ];
        }

        $currentUser = $this->authController->getCurrentUser();
        $userId = $currentUser['id'];

        // Debug: Log the incoming data
        error_log('Create Smart Link - Received data: ' . json_encode($data));
        // Check if user has reached their limit (free tier = 3 links)
        $config = require __DIR__ . '/../../config/app.php';
        $userLinkCount = $this->userModel->countSmartLinks($userId);

        if ($userLinkCount >= $config['free_tier']['max_links']) {
            return [
                'success' => false,
                'message' => 'You have reached your limit of ' . $config['free_tier']['max_links'] . ' smart links. Upgrade to create more.',
            ];
        }

        // Validate required fields
        if (empty($data['title'])) {
            return [
                'success' => false,
                'message' => 'Title is required',
            ];
        }
        if (empty($data['spotify_url'])) {
            return [
                'success' => false,
                'message' => 'Spotify URL is required',
            ];
        }

        try {
            // Extract metadata from Spotify URL if possible
            $metadata = null;
            if (!empty($data['spotify_url'])) {
                $metadata = $this->spotifyService->extractMetadata($data['spotify_url']);
                error_log('Spotify metadata: ' . ($metadata ? json_encode($metadata) : 'None extracted'));
            }

            if ($metadata) {
                // Use extracted metadata if available
                $linkData = [
                    'title' => $data['title'] ?? $metadata['title'],
                    'spotify_url' => $data['spotify_url'],
                    'artwork_url' => !empty($data['artwork_url']) ? $data['artwork_url'] : $metadata['artwork_url'],
                    'artist_name' => !empty($data['artist_name']) ? $data['artist_name'] : $metadata['artist_name'],
                    'track_name' => !empty($data['track_name']) ? $data['track_name'] : $metadata['track_name'],
                ];
            } else {
                // Use provided data without metadata
                $linkData = [
                    'title' => $data['title'] ?? 'My Smart Link',
                    'spotify_url' => $data['spotify_url'],
                    'artwork_url' => $data['artwork_url'] ?? null,
                    'artist_name' => $data['artist_name'] ?? null,
                    'track_name' => $data['track_name'] ?? null,
                ];
            }

            error_log('Creating smart link with data: ' . json_encode($linkData));

            // Create the smart link
            $smartLinkId = $this->smartLinkModel->create($userId, $linkData);

            if (!$smartLinkId) {
                error_log('Failed to create smart link');
                return [
                    'success' => false,
                    'message' => 'Failed to create smart link. Please try again.',
                ];
            }

            error_log('Smart link created with ID: ' . $smartLinkId);

            // Add platform links if provided
            if (!empty($data['platform_links']) && is_array($data['platform_links'])) {
                foreach ($data['platform_links'] as $platformLink) {
                    if (!empty($platformLink['platform_id']) && !empty($platformLink['platform_url'])) {
                        $this->smartLinkModel->addPlatformLink(
                            $smartLinkId,
                            $platformLink['platform_id'],
                            $platformLink['platform_url']
                        );
                    }
                }
            } else {
                error_log('No platform links provided or invalid format');
            }

            // Get the created smart link with slug
            $smartLink = $this->smartLinkModel->findById($smartLinkId);

            return [
                'success' => true,
                'message' => 'Smart link created successfully',
                'smart_link_id' => $smartLinkId,
                'slug' => $smartLink['slug'],
            ];
        } catch (Exception $e) {
            error_log('Exception in createSmartLink: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ];
        }
    }
    
    /**
     * Get a smart link by slug
     * 
     * @param string $slug Smart link slug
     * @return array Result with success status and data
     */
    public function getSmartLinkBySlug($slug) {
        $smartLink = $this->smartLinkModel->findBySlug($slug);
        
        if (!$smartLink) {
            return [
                'success' => false,
                'message' => 'Smart link not found',
            ];
        }
        
        // Get platform links
        $platformLinks = $this->smartLinkModel->getPlatformLinks($smartLink['id']);
        
        // Track page view
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $referrer = $_SERVER['HTTP_REFERER'] ?? null;
        
        $this->analyticsModel->trackPageView(
            $smartLink['id'],
            $ipAddress,
            $userAgent,
            $referrer
        );
        
        return [
            'success' => true,
            'message' => 'Smart link retrieved successfully',
            'data' => [
                'smart_link' => $smartLink,
                'platform_links' => $platformLinks,
            ],
        ];
    }
    
    /**
     * Get all smart links for the current user
     * 
     * @return array Result with success status and data
     */
    public function getUserSmartLinks() {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to view your smart links',
            ];
        }
        
        $currentUser = $this->authController->getCurrentUser();
        $userId = $currentUser['id'];
        
        // Get all user's smart links
        $smartLinks = $this->smartLinkModel->findByUserId($userId);
        
        // Get platform links and analytics for each smart link
        $enhancedLinks = [];
        
        $config = require __DIR__ . '/../../config/app.php';
        $analyticsDays = $config['free_tier']['analytics_retention_days'];
        
        foreach ($smartLinks as $link) {
            $platformLinks = $this->smartLinkModel->getPlatformLinks($link['id']);
            $pageViews = $this->analyticsModel->getPageViewCount($link['id'], $analyticsDays);
            $platformClicks = $this->analyticsModel->getPlatformClickCounts($link['id'], $analyticsDays);
            
            $enhancedLinks[] = [
                'smart_link' => $link,
                'platform_links' => $platformLinks,
                'analytics' => [
                    'page_views' => $pageViews,
                    'platform_clicks' => $platformClicks,
                ],
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Smart links retrieved successfully',
            'data' => $enhancedLinks,
        ];
    }
    
    /**
     * Delete a smart link
     * 
     * @param int $id Smart link ID
     * @return array Result with success status and message
     */
    public function deleteSmartLink($id) {
        // Check if user is logged in
        if (!$this->authController->isLoggedIn()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to delete a smart link',
            ];
        }
        
        $currentUser = $this->authController->getCurrentUser();
        $userId = $currentUser['id'];
        
        // Delete the smart link
        $success = $this->smartLinkModel->delete($id, $userId);
        
        if (!$success) {
            return [
                'success' => false,
                'message' => 'Failed to delete smart link. It may not exist or you do not have permission.',
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Smart link deleted successfully',
        ];
    }
    
    /**
     * Track a platform click
     * 
     * @param int $smartLinkId Smart link ID
     * @param int $platformId Platform ID
     * @return array Result with success status and message
     */
    public function trackPlatformClick($smartLinkId, $platformId) {
        // Get IP address, user agent, and referrer
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $referrer = $_SERVER['HTTP_REFERER'] ?? null;
        
        // Track the click
        $success = $this->analyticsModel->trackPlatformClick(
            $smartLinkId,
            $platformId,
            $ipAddress,
            $userAgent,
            $referrer
        );
        
        if (!$success) {
            return [
                'success' => false,
                'message' => 'Failed to track platform click',
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Platform click tracked successfully',
        ];
    }
}
