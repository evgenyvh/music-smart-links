<?php

require_once __DIR__ . '/../../config/database.php';

class Analytics {
    private $db;
    
    public function __construct() {
        $this->db = getDbConnection();
    }
    
    /**
     * Track a page view event
     * 
     * @param int $smartLinkId Smart link ID
     * @param string $ipAddress Visitor IP address
     * @param string $userAgent Visitor user agent
     * @param string $referrer Referrer URL
     * @return bool Success status
     */
    public function trackPageView($smartLinkId, $ipAddress = null, $userAgent = null, $referrer = null) {
        return $this->trackEvent($smartLinkId, null, 'pageview', $ipAddress, $userAgent, $referrer);
    }
    
    /**
     * Track a platform click event
     * 
     * @param int $smartLinkId Smart link ID
     * @param int $platformId Platform ID
     * @param string $ipAddress Visitor IP address
     * @param string $userAgent Visitor user agent
     * @param string $referrer Referrer URL
     * @return bool Success status
     */
    public function trackPlatformClick($smartLinkId, $platformId, $ipAddress = null, $userAgent = null, $referrer = null) {
        return $this->trackEvent($smartLinkId, $platformId, 'click', $ipAddress, $userAgent, $referrer);
    }
    
    /**
     * Track an event
     * 
     * @param int $smartLinkId Smart link ID
     * @param int|null $platformId Platform ID (null for page views)
     * @param string $eventType Event type (pageview or click)
     * @param string $ipAddress Visitor IP address
     * @param string $userAgent Visitor user agent
     * @param string $referrer Referrer URL
     * @return bool Success status
     */
    private function trackEvent($smartLinkId, $platformId, $eventType, $ipAddress, $userAgent, $referrer) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO analytics (
                    smart_link_id, platform_id, ip_address, 
                    user_agent, referrer, event_type
                )
                VALUES (
                    :smart_link_id, :platform_id, :ip_address,
                    :user_agent, :referrer, :event_type
                )
            ");
            
            $stmt->execute([
                ':smart_link_id' => $smartLinkId,
                ':platform_id' => $platformId,
                ':ip_address' => $ipAddress,
                ':user_agent' => $userAgent,
                ':referrer' => $referrer,
                ':event_type' => $eventType,
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log('Error tracking analytics event: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get page view count for a smart link
     * 
     * @param int $smartLinkId Smart link ID
     * @param int $days Number of days to look back (null for all time)
     * @return int Page view count
     */
    public function getPageViewCount($smartLinkId, $days = null) {
        $query = "
            SELECT COUNT(*) FROM analytics
            WHERE smart_link_id = :smart_link_id
            AND event_type = 'pageview'
        ";
        
        $params = [':smart_link_id' => $smartLinkId];
        
        if ($days !== null) {
            $query .= " AND created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)";
            $params[':days'] = $days;
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        
        return (int) $stmt->fetchColumn();
    }
    
    /**
     * Get platform click counts for a smart link
     * 
     * @param int $smartLinkId Smart link ID
     * @param int $days Number of days to look back (null for all time)
     * @return array Platform click counts
     */
    public function getPlatformClickCounts($smartLinkId, $days = null) {
        $query = "
            SELECT a.platform_id, mp.name, COUNT(*) as click_count
            FROM analytics a
            JOIN music_platforms mp ON a.platform_id = mp.id
            WHERE a.smart_link_id = :smart_link_id
            AND a.event_type = 'click'
        ";
        
        $params = [':smart_link_id' => $smartLinkId];
        
        if ($days !== null) {
            $query .= " AND a.created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)";
            $params[':days'] = $days;
        }
        
        $query .= " GROUP BY a.platform_id, mp.name ORDER BY click_count DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }
    
    /**
     * Clean up old analytics data for free tier users
     * 
     * @param int $retentionDays Number of days to keep data
     * @return int Number of records deleted
     */
    public function cleanupOldData($retentionDays) {
        $stmt = $this->db->prepare("
            DELETE a FROM analytics a
            JOIN smart_links sl ON a.smart_link_id = sl.id
            JOIN users u ON sl.user_id = u.id
            WHERE a.created_at < DATE_SUB(NOW(), INTERVAL :days DAY)
            AND u.plan_type = 'free' OR u.plan_type IS NULL
        ");
        
        $stmt->execute([':days' => $retentionDays]);
        
        return $stmt->rowCount();
    }
}
