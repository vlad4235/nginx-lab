<?php
require_once 'vendor/autoload.php';

use App\ElasticExample;

header('Content-Type: text/html; charset=utf-8');

\ = new ElasticExample();
\ = \['action'] ?? '';

// Примеры книг для индексации
\ = [
    '1' => [
        'title' => 'Мастер и Маргарита',
        'author' => 'Михаил Булгаков',
        'year' => 1967,
        'genre' => 'Роман',
        'description' => 'Великий роман о любви, искусстве и борьбе с цензурой.',
        'pages' => 480,
        'rating' => 4.8,
        'created_at' => '2024-01-01'
    ],
    '2' => [
        'title' => 'Преступление и наказание',
        'author' => 'Федор Достоевский', 
        'year' => 1866,
        'genre' => 'Психологический роман',
        'description' => 'История бывшего студента Родиона Раскольникова, совершившего убийство.',
        'pages' => 592,
        'rating' => 4.7,
        'created_at' => '2024-01-01'
    ],
    '3' => [
        'title' => '1984',
        'author' => 'Джордж Оруэлл',
        'year' => 1949,
        'genre' => 'Антиутопия',
        'description' => 'Роман-антиутопия о тоталитарном обществе будущего.',
        'pages' => 318,
        'rating' => 4.6,
        'created_at' => '2024-01-01'
    ],
    '4' => [
        'title' => 'Война и мир',
        'author' => 'Лев Толстой',
        'year' => 1869,
        'genre' => 'Эпопея',
        'description' => 'Монументальный роман-эпопея, описывающий русское общество в эпоху войн против Наполеона.',
        'pages' => 1225,
        'rating' => 4.9,
        'created_at' => '2024-01-01'
    ]
];

switch (\) {
    case 'create_index':
        \ = \->createBooksIndex();
        if (\['success']) {
            echo '<div class=\"success\">✅ Индекс книг успешно создан в Elasticsearch!</div>';
            echo '<div class=\"result-item\">';
            echo '<pre>' . json_encode(\['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>';
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка при создании индекса: ' . \['error'] . '</div>';
        }
        break;

    case 'add_books':
        \ = 0;
        \ = 0;
        
        foreach (\ as \ => \) {
            \ = \->indexBook(\, \);
            if (\['success']) {
                \++;
            } else {
                \++;
            }
        }

        echo '<div class=\"success\">✅ Книги добавлены в Elasticsearch!</div>';
        echo '<div class=\"result-item\">';
        echo '<p>Успешно добавлено: ' . \ . ' книг</p>';
        echo '<p>Ошибок: ' . \ . '</p>';
        echo '<h4>Добавленные книги:</h4>';
        foreach (\ as \) {
            echo '<div class=\"book-card\">';
            echo '<div class=\"book-title\">📖 ' . \['title'] . '</div>';
            echo '<div class=\"book-author\">✍️ ' . \['author'] . '</div>';
            echo '<div class=\"book-meta\">';
            echo '<span>📅 ' . \['year'] . ' год</span>';
            echo '<span>🏷️ ' . \['genre'] . '</span>';
            echo '<span>⭐ ' . \['rating'] . '</span>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        break;

    case 'search':
        \ = \['query'] ?? '';
        \ = \['genre'] ?? '';
        \ = \['year_from'] ?? '';
        
        \ = [];
        if (!empty(\)) {
            \['genre'] = \;
        }
        if (!empty(\)) {
            \['year_from'] = \;
        }

        \ = \->searchBooks(\, \);
        
        if (\['success']) {
            echo '<div class=\"success\">✅ Найдено книг: ' . \['total'] . '</div>';
            echo '<div class=\"result-item\">';
            
            if (empty(\['data'])) {
                echo '<p>По запросу \"' . htmlspecialchars(\) . '\" ничего не найдено.</p>';
            } else {
                foreach (\['data'] as \) {
                    \ = \['_source'];
                    echo '<div class=\"book-card\">';
                    echo '<div class=\"book-title\">📖 ' . \['title'] . '</div>';
                    echo '<div class=\"book-author\">✍️ ' . \['author'] . '</div>';
                    echo '<div class=\"book-meta\">';
                    echo '<span>📅 ' . \['year'] . ' год</span>';
                    echo '<span>🏷️ ' . \['genre'] . '</span>';
                    echo '<span>⭐ ' . \['rating'] . '</span>';
                    echo '</div>';
                    if (isset(\['highlight'])) {
                        echo '<div style=\"margin-top: 10px; font-size: 0.9em; color: #666;\">';
                        foreach (\['highlight'] as \ => \) {
                            echo '<p><strong>' . \ . ':</strong> ...' . implode('... ', \) . '...</p>';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка поиска: ' . \['error'] . '</div>';
        }
        break;

    case 'stats':
        \ = \->getIndexStats();
        if (\['success']) {
            echo '<div class=\"success\">✅ Статистика индекса книг</div>';
            echo '<div class=\"result-item\">';
            echo '<div class=\"stats-grid\">';
            echo '<div class=\"stat-card\">';
            echo '<div class=\"stat-number\">' . \['data']['total_documents'] . '</div>';
            echo '<div>Всего документов</div>';
            echo '</div>';
            echo '<div class=\"stat-card\">';
            echo '<div class=\"stat-number\">' . round(\['data']['index_size'] / 1024 / 1024, 2) . ' MB</div>';
            echo '<div>Размер индекса</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка получения статистики: ' . \['error'] . '</div>';
        }
        break;

    default:
        echo '<div class=\"error\">❌ Неизвестное действие</div>';
}
?>
