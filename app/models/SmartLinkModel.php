/**
 * Create a new smart link
 * 
 * @param int $userId User ID
 * @param array $data Smart link data
 * @param PDO $pdo Optional PDO connection
 * @return int|false The new smart link ID or false on failure
 */
public function create($userId, $data, $pdo = null) {
    // If no connection provided, get one
    $pdo = $pdo ?? getDbConnection();
    
    // Generate a unique slug
    $slug = $this->generateSlug($data['title'] ?? 'link');
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO smart_links 
            (user_id, title, slug, spotify_url, artwork_url, artist_name, track_name, created_at) 
            VALUES 
            (:user_id, :title, :slug, :spotify_url, :artwork_url, :artist_name, :track_name, NOW())
        ");
        
        $stmt->execute([
            ':user_id' => $userId,
            ':title' => $data['title'] ?? 'My Smart Link',
            ':slug' => $slug,
            ':spotify_url' => $data['spotify_url'],
            ':artwork_url' => $data['artwork_url'] ?? null,
            ':artist_name' => $data['artist_name'] ?? null,
            ':track_name' => $data['track_name'] ?? null,
        ]);
        
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log('Error creating smart link: ' . $e->getMessage());
        return false;
    }
}