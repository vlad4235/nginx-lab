<?php
/**
 * Класс для работы с внешним API
 * Лабораторная работа №4 - Интеграция с публичным API
 */
class ApiClient {
    private $apiUrl = 'https://api.tvmaze.com';
    
    public function __construct() {
        // Логирование инициализации
        error_log("ApiClient initialized");
    }
    
    /**
     * Получить список фильмов/сериалов по поисковому запросу
     */
    public function searchShows($query = 'action') {
        try {
            $url = $this->apiUrl . '/search/shows?q=' . urlencode($query);
            $response = $this->makeRequest($url);
            
            if (isset($response['error'])) {
                return $this->getFallbackData();
            }
            
            return array_slice($response, 0, 6); // Возвращаем первые 6 результатов
        } catch (Exception $e) {
            error_log("API Error: " . $e->getMessage());
            return $this->getFallbackData();
        }
    }
    
    /**
     * Получить популярные шоу
     */
    public function getPopularShows() {
        return $this->searchShows('popular');
    }
    
    /**
     * Сделать HTTP запрос
     */
    private function makeRequest($url) {
        // Используем cURL если доступен
        if (function_exists('curl_init')) {
            return $this->makeCurlRequest($url);
        } else {
            // Fallback на file_get_contents
            return $this->makeFileGetContentsRequest($url);
        }
    }
    
    private function makeCurlRequest($url) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_USERAGENT => 'Lab3-Cinema-App/1.0',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($ch)) {
            curl_close($ch);
            return ['error' => 'CURL Error: ' . curl_error($ch)];
        }
        
        curl_close($ch);
        
        if ($httpCode !== 200) {
            return ['error' => "HTTP Error: $httpCode"];
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'JSON Parse Error: ' . json_last_error_msg()];
        }
        
        return $data;
    }
    
    private function makeFileGetContentsRequest($url) {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: Lab3-Cinema-App/1.0',
                'timeout' => 10
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            return ['error' => 'Failed to fetch data from API'];
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' => 'JSON Parse Error: ' . json_last_error_msg()];
        }
        
        return $data;
    }
    
    /**
     * Fallback данные если API недоступно
     */
    public function getFallbackData() {
        return [
            [
                'show' => [
                    'name' => 'Breaking Bad',
                    'genres' => ['Drama', 'Crime', 'Thriller'],
                    'rating' => ['average' => 9.5],
                    'image' => ['medium' => 'https://via.placeholder.com/210x295/333333/FFFFFF?text=Breaking+Bad'],
                    'premiered' => '2008-01-20'
                ]
            ],
            [
                'show' => [
                    'name' => 'Game of Thrones',
                    'genres' => ['Fantasy', 'Drama', 'Adventure'],
                    'rating' => ['average' => 9.3],
                    'image' => ['medium' => 'https://via.placeholder.com/210x295/0066CC/FFFFFF?text=Game+of+Thrones'],
                    'premiered' => '2011-04-17'
                ]
            ],
            [
                'show' => [
                    'name' => 'Stranger Things',
                    'genres' => ['Horror', 'Sci-Fi', 'Drama'],
                    'rating' => ['average' => 8.7],
                    'image' => ['medium' => 'https://via.placeholder.com/210x295/660099/FFFFFF?text=Stranger+Things'],
                    'premiered' => '2016-07-15'
                ]
            ]
        ];
    }
}
?>