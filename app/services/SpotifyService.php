<?php

class SpotifyService {
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $tokenExpiry;
    
    public function __construct() {
        $config = require __DIR__ . '/../../config/app.php';
        $this->clientId = $config['spotify']['client_id'];
        $this->clientSecret = $config['spotify']['client_secret'];
        $this->accessToken = null;
        $this->tokenExpiry = 0;
    }
    
    /**
     * Extract metadata from a Spotify URL
     * 
     * @param string $spotifyUrl Spotify URL
     * @return array|false Metadata or false on failure
     */
    public function extractMetadata($spotifyUrl) {
        // Parse the Spotify URL to get the type (track, album, etc.) and ID
        $urlParts = parse_url($spotifyUrl);
        
        if (!isset($urlParts['path'])) {
            return false;
        }
        
        $pathParts = explode('/', trim($urlParts['path'], '/'));
        
        if (count($pathParts) < 2) {
            return false;
        }
        
        $resourceType = $pathParts[0]; // 'track', 'album', etc.
        $resourceId = $pathParts[1];
        
        // Ensure we have a valid token
        if (!$this->getAccessToken()) {
            return false;
        }
        
        // Fetch metadata based on resource type
        switch ($resourceType) {
            case 'track':
                return $this->getTrackMetadata($resourceId);
            case 'album':
                return $this->getAlbumMetadata($resourceId);
            case 'playlist':
                return $this->getPlaylistMetadata($resourceId);
            default:
                return false;
        }
    }
    
    /**
     * Get metadata for a track
     * 
     * @param string $trackId Spotify track ID
     * @return array|false Track metadata or false on failure
     */
    private function getTrackMetadata($trackId) {
        $data = $this->makeApiRequest("https://api.spotify.com/v1/tracks/{$trackId}");
        
        if (!$data) {
            return false;
        }
        
        return [
            'title' => $data['name'],
            'artist_name' => isset($data['artists'][0]) ? $data['artists'][0]['name'] : null,
            'artwork_url' => isset($data['album']['images'][0]) ? $data['album']['images'][0]['url'] : null,
            'track_name' => $data['name'],
            'type' => 'track',
        ];
    }
    
    /**
     * Get metadata for an album
     * 
     * @param string $albumId Spotify album ID
     * @return array|false Album metadata or false on failure
     */
    private function getAlbumMetadata($albumId) {
        $data = $this->makeApiRequest("https://api.spotify.com/v1/albums/{$albumId}");
        
        if (!$data) {
            return false;
        }
        
        return [
            'title' => $data['name'],
            'artist_name' => isset($data['artists'][0]) ? $data['artists'][0]['name'] : null,
            'artwork_url' => isset($data['images'][0]) ? $data['images'][0]['url'] : null,
            'track_name' => null, // Albums don't have a specific track
            'type' => 'album',
        ];
    }
    
    /**
     * Get metadata for a playlist
     * 
     * @param string $playlistId Spotify playlist ID
     * @return array|false Playlist metadata or false on failure
     */
    private function getPlaylistMetadata($playlistId) {
        $data = $this->makeApiRequest("https://api.spotify.com/v1/playlists/{$playlistId}");
        
        if (!$data) {
            return false;
        }
        
        return [
            'title' => $data['name'],
            'artist_name' => isset($data['owner']['display_name']) ? $data['owner']['display_name'] : null,
            'artwork_url' => isset($data['images'][0]) ? $data['images'][0]['url'] : null,
            'track_name' => null, // Playlists don't have a specific track
            'type' => 'playlist',
        ];
    }
    
    /**
     * Get an access token for Spotify API
     * 
     * @return string|false Access token or false on failure
     */
    private function getAccessToken() {
        // If we have a non-expired token, use it
        if ($this->accessToken && time() < $this->tokenExpiry) {
            return $this->accessToken;
        }
        
        // Otherwise, request a new token
        $tokenUrl = 'https://accounts.spotify.com/api/token';
        $headers = [
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            'Content-Type: application/x-www-form-urlencoded',
        ];
        
        $data = http_build_query([
            'grant_type' => 'client_credentials',
        ]);
        
        $ch = curl_init($tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            error_log('Error getting Spotify access token. HTTP code: ' . $httpCode);
            return false;
        }
        
        $responseData = json_decode($response, true);
        
        if (!isset($responseData['access_token']) || !isset($responseData['expires_in'])) {
            error_log('Invalid response from Spotify token endpoint.');
            return false;
        }
        
        $this->accessToken = $responseData['access_token'];
        $this->tokenExpiry = time() + $responseData['expires_in'] - 60; // 60 seconds buffer
        
        return $this->accessToken;
    }
    
    /**
     * Make an API request to Spotify
     * 
     * @param string $url API URL
     * @return array|false Response data or false on failure
     */
    private function makeApiRequest($url) {
        $headers = [
            'Authorization: Bearer ' . $this->accessToken,
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            error_log('Error accessing Spotify API. HTTP code: ' . $httpCode);
            return false;
        }
        
        return json_decode($response, true);
    }
}
