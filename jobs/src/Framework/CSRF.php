<?php
/**
 * CSRF Protection Helper
 */
class CSRF
{
    /**
     * Generate a CSRF token
     * @return string
     */
    public static function generateToken()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate a CSRF token
     * @param string $token
     * @return bool
     */
    public static function validateToken($token)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Get the CSRF token field HTML
     * @return string
     */
    public static function getField()
    {
        return '<input type="hidden" name="csrf_token" value="' . self::generateToken() . '">';
    }
}