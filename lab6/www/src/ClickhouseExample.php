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
                'Content-Type' => 'text/plain'
            ]
        ]);
    }

    /**
     * Создать таблицу для статистики чтения книг
     */
    public function createReadingStatsTable(): array
    {
        try {
            \ = '
                CREATE TABLE IF NOT EXISTS book_reading_stats (
                    user_id UInt32,
                    book_isbn String,
                    book_title String,
                    reading_date Date,
                    pages_read UInt16,
                    reading_time_seconds UInt32,
                    rating Nullable(Float32),
                    genre String,
                    author String
                ) ENGINE = MergeTree()
                PARTITION BY toYYYYMM(reading_date)
                ORDER BY (reading_date, user_id, book_isbn)
            ';

            \ = \->client->post('', ['body' => \]);

            return [
                'success' => true,
                'data' => \->getBody()->getContents()
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Добавить запись о чтении
     */
    public function addReadingStat(array \): array
    {
        try {
            \ = '
                INSERT INTO book_reading_stats FORMAT JSONEachRow
            ';

            \ = json_encode(\, JSON_UNESCAPED_UNICODE);

            \ = \->client->post('', [
                'body' => \ . \"\\n\" . \
            ]);

            return [
                'success' => true,
                'data' => \->getBody()->getContents()
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Получить статистику чтения по жанрам
     */
    public function getGenreStats(): array
    {
        try {
            \ = '
                SELECT 
                    genre,
                    COUNT(*) as total_reads,
                    SUM(pages_read) as total_pages,
                    AVG(reading_time_seconds) as avg_reading_time,
                    AVG(rating) as avg_rating
                FROM book_reading_stats 
                GROUP BY genre 
                ORDER BY total_reads DESC
            ';

            \ = \->client->post('', ['body' => \]);
            \ = \->getBody()->getContents();

            // Парсим TSV результат
            \ = explode(\"\\n\", trim(\));
            \ = explode(\"\\t\", \[0]);
            \ = [];

            for (\ = 1; \ < count(\); \++) {
                if (!empty(\[\])) {
                    \ = explode(\"\\t\", \[\]);
                    \[] = array_combine(\, \);
                }
            }

            return [
                'success' => true,
                'data' => \
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Получить популярные книги
     */
    public function getPopularBooks(int \ = 10): array
    {
        try {
            \ = \"
                SELECT 
                    book_isbn,
                    book_title,
                    author,
                    genre,
                    COUNT(*) as read_count,
                    AVG(rating) as avg_rating,
                    SUM(pages_read) as total_pages_read
                FROM book_reading_stats 
                GROUP BY book_isbn, book_title, author, genre
                ORDER BY read_count DESC, avg_rating DESC
                LIMIT \
            \";

            \ = \->client->post('', ['body' => \]);
            \ = \->getBody()->getContents();

            // Парсим TSV результат
            \ = explode(\"\\n\", trim(\));
            \ = explode(\"\\t\", \[0]);
            \ = [];

            for (\ = 1; \ < count(\); \++) {
                if (!empty(\[\])) {
                    \ = explode(\"\\t\", \[\]);
                    \[] = array_combine(\, \);
                }
            }

            return [
                'success' => true,
                'data' => \
            ];

        } catch (RequestException \) {
            return [
                'success' => false,
                'error' => \->getMessage()
            ];
        }
    }

    /**
     * Статистика чтения по месяцам
     */
    public function getMonthlyStats(): array
    {
        try {
            \ = '
                SELECT 
                    toYYYYMM(reading_date) as month,
                    COUNT(*) as total_reads,
                    SUM(pages_read) as total_pages,
                    COUNT(DISTINCT user_id) as unique_readers
                FROM book_reading_stats 
                GROUP BY month
                ORDER BY month DESC
            ';

            \ = \->client->post('', ['body' => \]);
            \ = \->getBody()->getContents();

            // Парсим TSV результат
            \ = explode(\"\\n\", trim(\));
            \ = explode(\"\\t\", \[0]);
            \ = [];

            for (\ = 1; \ < count(\); \++) {
                if (!empty(\[\])) {
                    \ = explode(\"\\t\", \[\]);
                    \[] = array_combine(\, \);
                }
            }

            return [
                'success' => true,
                'data' => \
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
