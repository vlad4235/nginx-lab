<?php

namespace App;

use App\Helpers\ClientFactory;
use GuzzleHttp\Exception\RequestException;

class ElasticExample
{
    private \;

    public function __construct()
    {
        \->client = ClientFactory::make('http://elasticsearch:9200/');
    }

    public function createIndex(\)
    {
        try {
            \ = \->client->put(\);
            return '✅ Индекс создан: ' . \->getBody()->getContents();
        } catch (RequestException \) {
            // Если индекс уже существует - это нормально
            if (\->getResponse() && \->getResponse()->getStatusCode() === 400) {
                return 'ℹ️ Индекс уже существует';
            }
            return '❌ Ошибка создания индекса: ' . \->getMessage();
        }
    }

    public function indexDocument(\, \, \)
    {
        try {
            \ = \->client->put('\/_doc/\', [
                'json' => \
            ]);
            return '✅ Документ добавлен: ' . \->getBody()->getContents();
        } catch (RequestException \) {
            return '❌ Ошибка добавления документа: ' . \->getMessage();
        }
    }

    public function search(\, \)
    {
        try {
            \ = \->client->get('\/_search', [
                'json' => ['query' => \]
            ]);
            return '🔍 Результаты поиска: ' . \->getBody()->getContents();
        } catch (RequestException \) {
            return '❌ Ошибка поиска: ' . \->getMessage();
        }
    }
}
