<?php

namespace App;

use App\Helpers\ClientFactory;
use GuzzleHttp\Exception\RequestException;

class ClickhouseExample
{
    private \;

    public function __construct()
    {
        \->client = ClientFactory::make('http://clickhouse:8123/', [
            'headers' => [
                'Content-Type' => 'text/plain',
            ]
        ]);
    }

    public function query(\)
    {
        try {
            \ = \->client->post('', [
                'body' => \
            ]);
            return '✅ Результат запроса: ' . \->getBody()->getContents();
        } catch (RequestException \) {
            return '❌ Ошибка ClickHouse: ' . \->getMessage();
        }
    }

    public function createTable(\)
    {
        \ = 'CREATE TABLE IF NOT EXISTS ' . \ . ' (
            id Int32,
            name String,
            timestamp DateTime
        ) ENGINE = Memory';
        
        return \->query(\);
    }
}
