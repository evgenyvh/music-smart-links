<?php

require_once __DIR__ . '/../../config/database.php';

class SmartLink {
    private $db;
    
    public function __construct() {
        $this->db = getDbConnection();
    }
    
    /**
     * Create a new smart link
     * 
     * @param int $userId User ID
     * @param array $linkData Link data (title, spotify_url, etc.)
     * @return int|bool New link ID or false on failure
     */
    public function create($userId, $linkData) {
        try {
            // Generate a unique slug
            $slug = $this->generateSlug($linkData['title'] ?? '');
            
            $stmt = $this->db->prepare("
                INSERT INTO smart_links (
                    user_id, title, spotify_url, artwork_url, 
                    artist_name, track_name, slug
                )
                VALUES (
                    :user_id, :title, :spotify_url, :artwork_url,
                    :artist_name, :track_name, :slug
                )
            ");
            
            $stmt->execute([
                ':user_id' => $userId,
                ':title' => $linkData['title'] ?? '',
                ':spotify_url' => $linkData['spotify_url'],
                ':artwork_url' => $linkData['artwork_url'] ?? null,
                ':artist_name' => $linkData['artist_name'] ?? null,
                ':track_name' => $linkData['track_name'] ?? null,
                ':slug' => $slug,
            ]);
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log('Error creating smart link: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get smart link by ID
     * 
     * @param int $id Smart link ID
     * @return array|false Smart link data or false if not found
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM smart_links WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Get smart link by slug
     * 
     * @param string $slug Smart link slug
     * @return array|false Smart link data or false if not found
     */
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM smart_links WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch();
    }
    
    /**
     * Get all smart links for a user
     * 
     * @param int $userId User ID
     * @return array Smart links
     */
    public function findByUserId($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM smart_links 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Add a platform link to a smart link
     * 
     * @param int $smartLinkId Smart link ID
     * @param int $platformId Platform ID
     * @param string $platformUrl Platform URL
     * @return bool Success status
     */
    public function addPlatformLink($smartLinkId, $platformId, $platformUrl) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO link_platforms (smart_link_id, platform_id, platform_url)
                VALUES (:smart_link_id, :platform_id, :platform_url)
            ");
            
            $stmt->execute([
                ':smart_link_id' => $smartLinkId,
                ':platform_id' => $platformId,
                ':platform_url' => $platformUrl,
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log('Error adding platform link: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get all platform links for a smart link
     * 
     * @param int $smartLinkId Smart link ID
     * @return array Platform links
     */
    public function getPlatformLinks($smartLinkId) {
        $stmt = $this->db->prepare("
            SELECT lp.*, mp.name, mp.icon, mp.base_url
            FROM link_platforms lp
            JOIN music_platforms mp ON lp.platform_id = mp.id
            WHERE lp.smart_link_id = :smart_link_id
        ");
        $stmt->execute([':smart_link_id' => $smartLinkId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Delete a smart link
     * 
     * @param int $id Smart link ID
     * @param int $userId User ID (for verification)
     * @return bool Success status
     */
    public function delete($id, $userId) {
        $stmt = $this->db->prepare("
            DELETE FROM smart_links 
            WHERE id = :id AND user_id = :user_id
        ");
        $stmt->execute([
            ':id' => $id,
            ':user_id' => $userId,
        ]);
        
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Generate a unique slug
     * 
     * @param string $title Title to base the slug on
     * @return string Unique slug
     */
    private function generateSlug($title) {
        // Create base slug from title or random string if empty
        if (empty($title)) {
            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $title = '';
            for ($i = 0; $i < 8; $i++) {
                $title .= $characters[rand(0, strlen($characters) - 1)];
            }
        }
        
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $title), '-'));
        
        // Check if slug exists, if so, add a random suffix
        $baseSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Check if a slug already exists
     * 
     * @param string $slug Slug to check
     * @return bool True if exists
     */
    private function slugExists($slug) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM smart_links WHERE slug = :slug
        ");
        $stmt->execute([':slug' => $slug]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
