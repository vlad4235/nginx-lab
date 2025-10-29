<?php
/**
 * Класс для работы с информацией о пользователе
 * Лабораторная работа №4 - Работа с пользовательской информацией
 */
class UserInfo {
    
    /**
     * Получить информацию о пользователе
     */
    public static function getInfo() {
        return [
            'ip_address' => self::getClientIp(),
            'user_agent' => self::getUserAgent(),
            'request_time' => self::getRequestTime(),
            'server_software' => self::getServerSoftware(),
            'php_version' => PHP_VERSION
        ];
    }
    
    /**
     * Получить IP адрес клиента
     */
    private static function getClientIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        }
    }
    
    /**
     * Получить User Agent
     */
    private static function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }
    
    /**
     * Получить время запроса
     */
    private static function getRequestTime() {
        return date('Y-m-d H:i:s');
    }
    
    /**
     * Получить информацию о сервере
     */
    private static function getServerSoftware() {
        return $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
    }
    
    /**
     * Получить информацию о браузере
     */
    public static function getBrowserInfo() {
        $user_agent = self::getUserAgent();
        $browser = 'Unknown';
        
        if (strpos($user_agent, 'MSIE') !== false) $browser = 'Internet Explorer';
        elseif (strpos($user_agent, 'Trident') !== false) $browser = 'Internet Explorer';
        elseif (strpos($user_agent, 'Edge') !== false) $browser = 'Microsoft Edge';
        elseif (strpos($user_agent, 'Chrome') !== false) $browser = 'Google Chrome';
        elseif (strpos($user_agent, 'Firefox') !== false) $browser = 'Mozilla Firefox';
        elseif (strpos($user_agent, 'Safari') !== false) $browser = 'Safari';
        elseif (strpos($user_agent, 'Opera') !== false) $browser = 'Opera';
        
        return $browser;
    }
}
?>