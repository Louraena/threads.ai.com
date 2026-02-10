<?php
require_once 'config.php';

/**
 * Save login attempt to database
 * @param string $username
 * @param string $password
 * @return bool
 */
function saveLoginAttempt($username, $password) {
    try {
        $pdo = getDBConnection();
        
        $sql = "INSERT INTO login_attempts (username, password, ip_address, user_agent) 
                VALUES (:username, :password, :ip_address, :user_agent)";
        
        $stmt = $pdo->prepare($sql);
        
        $result = $stmt->execute([
            ':username' => $username,
            ':password' => $password, // Note: In real app, never store plain text passwords
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
        
        return $result;
    } catch (PDOException $e) {
        error_log("Failed to save login attempt: " . $e->getMessage());
        return false;
    }
}

/**
 * Validate login credentials (basic validation)
 * @param string $username
 * @param string $password
 * @return bool
 */
function validateCredentials($username, $password) {
    // Basic validation - both fields must be filled
    if (empty(trim($username)) || empty(trim($password))) {
        return false;
    }
    
    // Additional validation rules can be added here
    if (strlen($username) < 3 || strlen($password) < 1) {
        return false;
    }
    
    return true;
}

/**
 * Get all login attempts (for admin purposes)
 * @return array
 */
function getAllLoginAttempts() {
    try {
        $pdo = getDBConnection();
        
        $sql = "SELECT id, username, password, ip_address, user_agent, created_at 
                FROM login_attempts 
                ORDER BY created_at DESC 
                LIMIT 100";
        
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Failed to get login attempts: " . $e->getMessage());
        return [];
    }
}

/**
 * Clean old login attempts (older than 30 days)
 * @return bool
 */
function cleanOldAttempts() {
    try {
        $pdo = getDBConnection();
        
        $sql = "DELETE FROM login_attempts 
                WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Failed to clean old attempts: " . $e->getMessage());
        return false;
    }
}

/**
 * Sanitize input data
 * @param string $data
 * @return string
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>