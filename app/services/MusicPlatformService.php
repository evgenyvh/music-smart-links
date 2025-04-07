<?php

class MusicPlatformService {
    private $spotifyService;
    private $apiKeys;

    public function __construct() {
        $this->spotifyService = new SpotifyService();

        // Load API keys from config
        $config = require __DIR__ . '/../../config/app.php';
        $this->apiKeys = $config['api_keys'] ?? [];
    }

    /**
     * Find matching links on other platforms based on Spotify metadata
     * 
     * @param string $spotifyUrl Spotify URL
     * @return array Platform links
     */
    public function findMatchingLinks($spotifyUrl) {
        // Extract metadata from Spotify URL
        $metadata = $this->spotifyService->extractMetadata($spotifyUrl);

        if (!$metadata) {
            return [
                'success' => false,
                'message' => 'Could not extract metadata from Spotify URL',
                'links' => []
            ];
        }

        // Initialize results array
        $results = [
            'success' => true,
            'message' => 'Found matching links',
            'metadata' => $metadata,
            'links' => []
        ];

        // Search on different platforms
        $appleMusicLink = $this->searchAppleMusic($metadata);
        if ($appleMusicLink) {
            $results['links'][] = [
                'platform_id' => 2, // Apple Music ID
                'platform_name' => 'Apple Music',
                'platform_url' => $appleMusicLink
            ];
        }

        $deezerLink = $this->searchDeezer($metadata);
        if ($deezerLink) {
            $results['links'][] = [
                'platform_id' => 6, // Deezer ID
                'platform_name' => 'Deezer',
                'platform_url' => $deezerLink
            ];
        }

        $youtubeMusicLink = $this->searchYouTubeMusic($metadata);
        if ($youtubeMusicLink) {
            $results['links'][] = [
                'platform_id' => 3, // YouTube Music ID
                'platform_name' => 'YouTube Music',
                'platform_url' => $youtubeMusicLink
            ];
        }

        $amazonMusicLink = $this->searchAmazonMusic($metadata);
        if ($amazonMusicLink) {
            $results['links'][] = [
                'platform_id' => 4, // Amazon Music ID
                'platform_name' => 'Amazon Music',
                'platform_url' => $amazonMusicLink
            ];
        }

        return $results;
    }

    /**
     * Search for track on Apple Music
     * 
     * @param array $metadata Track metadata
     * @return string|false Apple Music URL or false if not found
     */
    private function searchAppleMusic($metadata) {
        $searchTerm = urlencode($metadata['artist_name'] . ' ' . $metadata['track_name']);
        $url = "https://itunes.apple.com/search?term={$searchTerm}&media=music&entity=song&limit=1";

        $response = $this->makeApiRequest($url);

        if ($response && isset($response['results']) && !empty($response['results'])) {
            $result = $response['results'][0];
            return $result['trackViewUrl'];
        }

        return false;
    }

    /**
     * Search for track on Deezer
     * 
     * @param array $metadata Track metadata
     * @return string|false Deezer URL or false if not found
     */
    private function searchDeezer($metadata) {
        $searchTerm = urlencode($metadata['artist_name'] . ' ' . $metadata['track_name']);
        $url = "https://api.deezer.com/search?q={$searchTerm}&limit=1";

        $response = $this->makeApiRequest($url);

        if ($response && isset($response['data']) && !empty($response['data'])) {
            $result = $response['data'][0];
            return "https://www.deezer.com/track/{$result['id']}";
        }

        return false;
    }

    /**
     * Search for track on YouTube Music
     * 
     * @param array $metadata Track metadata
     * @return string|false YouTube Music URL or false if not found
     */
    private function searchYouTubeMusic($metadata) {
        // YouTube Music doesn't have a public API, so we'll simulate a search result
        // In a production environment, you might use YouTube Data API or a scraping solution

        $searchTerm = urlencode($metadata['artist_name'] . ' ' . $metadata['track_name']);

        // This is a simulated result - in production, you would implement a real search
        return "https://music.youtube.com/search?q={$searchTerm}";
    }

    /**
     * Search for track on Amazon Music
     * 
     * @param array $metadata Track metadata
     * @return string|false Amazon Music URL or false if not found
     */
    private function searchAmazonMusic($metadata) {
        // Amazon Music doesn't have a public API, so we'll simulate a search result
        // In a production environment, you might use a scraping solution

        $searchTerm = urlencode($metadata['artist_name'] . ' ' . $metadata['track_name']);

        // This is a simulated result - in production, you would implement a real search
        return "https://music.amazon.com/search/{$searchTerm}";
    }

    /**
     * Make API request
     * 
     * @param string $url API URL
     * @return array|false Response data or false on failure
     */
    private function makeApiRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300 && $response) {
            return json_decode($response, true);
        }

        return false;
    }
}