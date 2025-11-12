<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class ClientFactory
{
    public static function make(string \, array \ = []): Client
    {
        \ = [
            'timeout'  => 10.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ];

        return new Client(array_merge(\, \, [
            'base_uri' => \,
        ]));
    }
}
