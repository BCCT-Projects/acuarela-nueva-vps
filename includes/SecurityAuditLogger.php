<?php

/**
 * SecurityAuditLogger
 * 
 * Centralized logger for security and compliance events (SOC 2 / ISO 27001).
 * Writes structured JSON logs to the project root logs directory.
 * 
 * Usage:
 * SecurityAuditLogger::log('auth_login_success', 'INFO', ['user_id' => 123]);
 */
class SecurityAuditLogger
{
    private static $instance = null;
    private $logFile;
    
    // Severity Levels
    const SEVERITY_INFO = 'INFO';
    const SEVERITY_WARN = 'WARN';
    const SEVERITY_ERROR = 'ERROR';
    const SEVERITY_CRITICAL = 'CRITICAL';

    private function __construct()
    {
        // Define log path relative to this file (includes/ -> parent -> logs/)
        $this->logFile = __DIR__ . '/../logs/audit.log';
        
        // Ensure log directory exists
        $logDir = dirname($this->logFile);
        if (!file_exists($logDir)) {
            // Attempt to create it if it doesn't exist (though it should)
            @mkdir($logDir, 0755, true);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Log a security event
     *
     * @param string $eventType Snake_case event name (e.g., 'auth_login_failed')
     * @param string $severity INFO, WARN, ERROR, CRITICAL
     * @param array $details Additional context
     * @param string|null $userId Optional, will try to fetch from session if null
     */
    public static function log($eventType, $severity = self::SEVERITY_INFO, $details = [], $userId = null)
    {
        $logger = self::getInstance();
        $logger->writeLog($eventType, $severity, $details, $userId);
    }

    private function writeLog($eventType, $severity, $details, $userId)
    {
        // 1. Capture Context
        $timestamp = date('Y-m-d\TH:i:sP'); // ISO 8601
        $ip = $this->getClientIp();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        $script = $_SERVER['SCRIPT_NAME'] ?? 'CLI';
        
        // Auto-detect user if not provided
        if ($userId === null) {
             // Try common session locations (adjust based on actual app structure)
             if (isset($_SESSION['user_id'])) {
                 $userId = $_SESSION['user_id'];
             } elseif (isset($_SESSION['id_user'])) {
                 $userId = $_SESSION['id_user'];
             }
        }

        // 2. Build Structured JSON
        $entry = [
            'timestamp' => $timestamp,
            'event_type' => $eventType,
            'severity' => $severity,
            'user_id' => $userId,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'resource' => $script,
            'details' => $details
        ];

        // 3. Serialize and Write
        // JSON_UNESCAPED_SLASHES for readable URLs, JSON_UNESCAPED_UNICODE for proper text
        $line = json_encode($entry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
        
        // Atomic write (mostly atomic with FILE_APPEND)
        // If file is explicitly locked by another process this might block, but usually fine for simple logs
        file_put_contents($this->logFile, $line, FILE_APPEND | LOCK_EX);
    }

    private function getClientIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }
    }
}
