<?php
require_once 'vendor/autoload.php';

use App\ClickhouseExample;

header('Content-Type: text/html; charset=utf-8');

\ = new ClickhouseExample();
\ = \['action'] ?? '';

// Примеры статистики чтения
\ = [
    [
        'user_id' => 101,
        'book_isbn' => '978-5-699-12014-7',
        'book_title' => 'Мастер и Маргарита',
        'reading_date' => '2024-01-15',
        'pages_read' => 120,
        'reading_time_seconds' => 7200,
        'rating' => 5.0,
        'genre' => 'Роман',
        'author' => 'Михаил Булгаков'
    ],
    [
        'user_id' => 102,
        'book_isbn' => '978-5-17-090830-7',
        'book_title' => 'Преступление и наказание',
        'reading_date' => '2024-01-20',
        'pages_read' => 85,
        'reading_time_seconds' => 5100,
        'rating' => 4.5,
        'genre' => 'Психологический роман',
        'author' => 'Федор Достоевский'
    ],
    [
        'user_id' => 103,
        'book_isbn' => '978-5-389-08228-8',
        'book_title' => '1984',
        'reading_date' => '2024-01-25',
        'pages_read' => 200,
        'reading_time_seconds' => 9000,
        'rating' => 4.8,
        'genre' => 'Антиутопия',
        'author' => 'Джордж Оруэлл'
    ],
    [
        'user_id' => 104,
        'book_isbn' => '978-5-699-80688-3',
        'book_title' => 'Война и мир',
        'reading_date' => '2024-02-01',
        'pages_read' => 150,
        'reading_time_seconds' => 10800,
        'rating' => 4.9,
        'genre' => 'Эпопея',
        'author' => 'Лев Толстой'
    ],
    [
        'user_id' => 101,
        'book_isbn' => '978-5-389-08228-8',
        'book_title' => '1984',
        'reading_date' => '2024-02-05',
        'pages_read' => 118,
        'reading_time_seconds' => 5400,
        'rating' => 4.7,
        'genre' => 'Антиутопия',
        'author' => 'Джордж Оруэлл'
    ]
];

switch (\) {
    case 'create_table':
        \ = \->createReadingStatsTable();
        if (\['success']) {
            echo '<div class=\"success\">✅ Таблица статистики чтения создана в ClickHouse!</div>';
            echo '<div class=\"result-item\">';
            echo '<p>Таблица <strong>book_reading_stats</strong> успешно создана.</p>';
            echo '<p>Структура таблицы:</p>';
            echo '<ul>';
            echo '<li>user_id - ID пользователя</li>';
            echo '<li>book_isbn - ISBN книги</li>';
            echo '<li>book_title - Название книги</li>';
            echo '<li>reading_date - Дата чтения</li>';
            echo '<li>pages_read - Прочитано страниц</li>';
            echo '<li>reading_time_seconds - Время чтения (секунды)</li>';
            echo '<li>rating - Оценка книги</li>';
            echo '<li>genre - Жанр книги</li>';
            echo '<li>author - Автор книги</li>';
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка при создании таблицы: ' . \['error'] . '</div>';
        }
        break;

    case 'add_stats':
        \ = 0;
        \ = 0;
        
        foreach (\ as \) {
            \ = \->addReadingStat(\);
            if (\['success']) {
                \++;
            } else {
                \++;
            }
        }

        echo '<div class=\"success\">✅ Статистика чтения добавлена в ClickHouse!</div>';
        echo '<div class=\"result-item\">';
        echo '<p>Успешно добавлено: ' . \ . ' записей</p>';
        echo '<p>Ошибок: ' . \ . '</p>';
        echo '<h4>Добавленные записи:</h4>';
        foreach (\ as \) {
            echo '<div class=\"book-card\">';
            echo '<div class=\"book-title\">📖 ' . \['book_title'] . '</div>';
            echo '<div class=\"book-author\">✍️ ' . \['author'] . '</div>';
            echo '<div class=\"book-meta\">';
            echo '<span>👤 Пользователь: ' . \['user_id'] . '</span>';
            echo '<span>📅 ' . \['reading_date'] . '</span>';
            echo '<span>📄 ' . \['pages_read'] . ' стр.</span>';
            echo '<span>⏱️ ' . round(\['reading_time_seconds'] / 3600, 1) . ' ч</span>';
            echo '<span>⭐ ' . \['rating'] . '</span>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        break;

    case 'genre_stats':
        \ = \->getGenreStats();
        if (\['success']) {
            echo '<div class=\"success\">✅ Статистика чтения по жанрам</div>';
            echo '<div class=\"result-item\">';
            echo '<div class=\"stats-grid\">';
            
            foreach (\['data'] as \) {
                echo '<div class=\"stat-card\">';
                echo '<div class=\"stat-number\">' . \['genre'] . '</div>';
                echo '<div>Прочтений: ' . \['total_reads'] . '</div>';
                echo '<div>Страниц: ' . \['total_pages'] . '</div>';
                echo '<div>Время: ' . round(\['avg_reading_time'] / 60, 1) . ' мин</div>';
                echo '<div>Рейтинг: ' . round(\['avg_rating'], 1) . '</div>';
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка получения статистики: ' . \['error'] . '</div>';
        }
        break;

    case 'popular_books':
        \ = \->getPopularBooks(5);
        if (\['success']) {
            echo '<div class=\"success\">✅ Топ популярных книг</div>';
            echo '<div class=\"result-item\">';
            
            foreach (\['data'] as \ => \) {
                echo '<div class=\"book-card\">';
                echo '<div class=\"book-title\">#' . (\ + 1) . ' 📖 ' . \['book_title'] . '</div>';
                echo '<div class=\"book-author\">✍️ ' . \['author'] . '</div>';
                echo '<div class=\"book-meta\">';
                echo '<span>🏷️ ' . \['genre'] . '</span>';
                echo '<span>👥 Прочтений: ' . \['read_count'] . '</span>';
                echo '<span>⭐ Рейтинг: ' . round(\['avg_rating'], 1) . '</span>';
                echo '<span>📄 Страниц: ' . \['total_pages_read'] . '</span>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка получения популярных книг: ' . \['error'] . '</div>';
        }
        break;

    case 'monthly_stats':
        \ = \->getMonthlyStats();
        if (\['success']) {
            echo '<div class=\"success\">✅ Статистика чтения по месяцам</div>';
            echo '<div class=\"result-item\">';
            echo '<div class=\"stats-grid\">';
            
            foreach (\['data'] as \) {
                \ = substr(\['month'], 0, 4) . '-' . substr(\['month'], 4, 2);
                echo '<div class=\"stat-card\">';
                echo '<div class=\"stat-number\">' . \ . '</div>';
                echo '<div>Прочтений: ' . \['total_reads'] . '</div>';
                echo '<div>Страниц: ' . \['total_pages'] . '</div>';
                echo '<div>Читателей: ' . \['unique_readers'] . '</div>';
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка получения месячной статистики: ' . \['error'] . '</div>';
        }
        break;

    default:
        echo '<div class=\"error\">❌ Неизвестное действие</div>';
}
?>
