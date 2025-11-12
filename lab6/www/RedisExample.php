<?php

namespace App;

use App\Helpers\ClientFactory;
use GuzzleHttp\Exception\RequestException;

class RedisExample
{
    private \;

    public function __construct()
    {
        // Используем redis-commander для HTTP доступа
        \->client = ClientFactory::make('http://redis-commander:8081/');
    }

    public function setValue(\, \)
    {
        try {
            // Для простоты используем прямое подключение к Redis
            \ = new \Redis();
            \->connect('redis', 6379);
            \ = \->set(\, json_encode(\));
            \->close();
            return \ ? '✅ Значение установлено: ' . \ : '❌ Ошибка установки значения';
        } catch (\Exception \) {
            return '❌ Ошибка Redis: ' . \->getMessage();
        }
    }

    public function getValue(\)
    {
        try {
            \ = new \Redis();
            \->connect('redis', 6379);
            \ = \->get(\);
            \->close();
            return \ ? '✅ Значение ' . \ . ': ' . \ : '❌ Ключ не найден';
        } catch (\Exception \) {
            return '❌ Ошибка Redis: ' . \->getMessage();
        }
    }
}
