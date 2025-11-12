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

    /**
     * Создать индекс для книг
     */
    public function createBooksIndex(): array
    {
        try {
            \ = [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'russian'
                        ],
                        'author' => [
                            'type' => 'text',
                            'analyzer' => 'russian'
                        ],
                        'description' => [
                            'type' => 'text',
                            'analyzer' => 'russian'
                        ],
                        'isbn' => [
                            'type' => 'keyword'
                        ],
                        'year' => [
                            'type' => 'integer'
                        ],
                        'genre' => [
                            'type' => 'keyword'
                        ],
                        'rating' => [
                            'type' => 'float'
                        ],
                        'pages' => [
                            'type' => 'integer'
                        ],
                        'created_at' => [
                            'type' => 'date'
                        ]
                    ]
                ]
            ];

            \ = \->client->put('books', [
                'json' => \
            ]);

            return [
                'success' => true,
                'data' => json_decode(\->getBody()->getContents(), true)
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Добавить книгу в индекс
     */
    public function indexBook(string \, array \): array
    {
        try {
            \ = \->client->put(\"books/_doc/\\", [
                'json' => \
            ]);

            return [
                'success' => true,
                'data' => json_decode(\->getBody()->getContents(), true)
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Поиск книг
     */
    public function searchBooks(string \, array \ = []): array
    {
        try {
            \ = [
                'query' => [
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => \,
                                'fields' => ['title', 'author', 'description', 'genre'],
                                'fuzziness' => 'AUTO'
                            ]
                        ]
                    ]
                ],
                'sort' => [
                    ['_score' => ['order' => 'desc']],
                    ['year' => ['order' => 'desc']]
                ],
                'highlight' => [
                    'fields' => [
                        'title' => new \stdClass(),
                        'author' => new \stdClass(),
                        'description' => new \stdClass()
                    ]
                ]
            ];

            // Добавляем фильтры если есть
            if (!empty(\['genre'])) {
                \['query']['bool']['filter'][] = [
                    'term' => ['genre' => \['genre']]
                ];
            }

            if (!empty(\['year_from']) || !empty(\['year_to'])) {
                \ = [];
                if (!empty(\['year_from'])) {
                    \['gte'] = (int)\['year_from'];
                }
                if (!empty(\['year_to'])) {
                    \['lte'] = (int)\['year_to'];
                }
                \['query']['bool']['filter'][] = [
                    'range' => ['year' => \]
                ];
            }

            \ = \->client->get('books/_search', [
                'json' => \
            ]);

            \ = json_decode(\->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => \['hits']['hits'] ?? [],
                'total' => \['hits']['total']['value'] ?? 0
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Получить статистику по индексу
     */
    public function getIndexStats(): array
    {
        try {
            \ = \->client->get('books/_stats');
            \ = json_decode(\->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => [
                    'total_documents' => \['_all']['total']['docs']['count'] ?? 0,
                    'index_size' => \['_all']['total']['store']['size_in_bytes'] ?? 0
                ]
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Автодополнение для поиска
     */
    public function suggestBooks(string \): array
    {
        try {
            \ = [
                'suggest' => [
                    'book_suggest' => [
                        'prefix' => \,
                        'completion' => [
                            'field' => 'title_suggest',
                            'size' => 5
                        ]
                    ]
                ]
            ];

            \ = \->client->get('books/_search', [
                'json' => \
            ]);

            \ = json_decode(\->getBody()->getContents(), true);

            return [
                'success' => true,
                'suggestions' => \['suggest']['book_suggest'][0]['options'] ?? []
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }
}
?>
