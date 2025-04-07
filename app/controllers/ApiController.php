<?php

require_once __DIR__ . '/../services/MusicPlatformService.php';
require_once __DIR__ . '/../services/SpotifyService.php';

class ApiController {
    private $musicPlatformService;
    private $spotifyService;
    
    public function __construct() {
        $this->musicPlatformService = new MusicPlatformService();
        $this->spotifyService = new SpotifyService();
    }
    
    /**
     * Extract metadata from Spotify URL
     * 
     * @param string $spotifyUrl Spotify URL
     * @return array Response with metadata
     */
    public function extractMetadata($spotifyUrl) {
        $metadata = $this->spotifyService->extractMetadata($spotifyUrl);
        
        if (!$metadata) {
            return [
                'success' => false,
                'message' => 'Could not extract metadata from Spotify URL'
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Metadata extracted successfully',
            'metadata' => $metadata
        ];
    }
    
    /**
     * Find matching links on other platforms
     * 
     * @param string $spotifyUrl Spotify URL
     * @return array Response with platform links
     */
    public function findMatchingLinks($spotifyUrl) {
        return $this->musicPlatformService->findMatchingLinks($spotifyUrl);
    }
    
    /**
     * Handle API requests
     * 
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @return array Response data
     */
    public function handleRequest($endpoint, $data) {
        switch ($endpoint) {
            case 'extract-metadata':
                if (empty($data['spotify_url'])) {
                    return [
                        'success' => false,
                        'message' => 'Spotify URL is required'
                    ];
                }
                return $this->extractMetadata($data['spotify_url']);
                
            case 'find-matching-links':
                if (empty($data['spotify_url'])) {
                    return [
                        'success' => false,
                        'message' => 'Spotify URL is required'
                    ];
                }
                return $this->findMatchingLinks($data['spotify_url']);
                
            default:
                return [
                    'success' => false,
                    'message' => 'Invalid API endpoint'
                ];
        }
    }
}