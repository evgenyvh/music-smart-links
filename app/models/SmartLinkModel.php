/**
 * Add a platform link to a smart link
 * 
 * @param int $smartLinkId Smart link ID
 * @param int $platformId Platform ID
 * @param string $platformUrl Platform URL
 * @param PDO $pdo Optional PDO connection
 * @return bool Success status
 */
public function addPlatformLink($smartLinkId, $platformId, $platformUrl, $pdo = null) {
    // If no PDO connection provided, get one
    $db = $pdo ?? $this->db;
    
    try {
        error_log("Adding platform link: SmartLink ID=$smartLinkId, Platform ID=$platformId, URL=$platformUrl");
        
        $stmt = $db->prepare("
            INSERT INTO link_platforms (smart_link_id, platform_id, platform_url)
            VALUES (:smart_link_id, :platform_id, :platform_url)
        ");
        
        $result = $stmt->execute([
            ':smart_link_id' => $smartLinkId,
            ':platform_id' => $platformId,
            ':platform_url' => $platformUrl,
        ]);
        
        error_log("Platform link addition result: " . ($result ? 'success' : 'failure'));
        
        return $result;
    } catch (PDOException $e) {
        error_log('Error adding platform link: ' . $e->getMessage());
        return false;
    }
}