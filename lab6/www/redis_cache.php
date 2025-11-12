<?php
require_once 'vendor/autoload.php';

use App\RedisExample;

header('Content-Type: text/html; charset=utf-8');

\ = new RedisExample();
\ = \['action'] ?? '';

// Примеры книг для кэширования
\ = [
    [
        'title' => 'Мастер и Маргарита',
        'author' => 'Михаил Булгаков',
        'year' => 1967,
        'rating' => 4.8
    ],
    [
        'title' => 'Преступление и наказание', 
        'author' => 'Федор Достоевский',
        'year' => 1866,
        'rating' => 4.7
    ]
];

switch (\) {
    case 'cache':
        \ = \->cachePopularBooks(\);
        if (\) {
            echo '<div class=\"success\">✅ Книги успешно закэшированы в Redis!</div>';
            echo '<div class=\"result-item\">';
            echo '<h4>Закэшированные книги:</h4>';
            foreach (\ as \) {
                echo '<p><strong>📖 ' . \['title'] . '</strong> - ' . \['author'] . ' (' . \['year'] . ')</p>';
            }
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ Ошибка при кэшировании в Redis</div>';
        }
        break;

    case 'get':
        \ = \->getCachedPopularBooks();
        if (\) {
            echo '<div class=\"success\">✅ Данные получены из Redis кэша!</div>';
            echo '<div class=\"result-item\">';
            echo '<h4>Кэшированные книги:</h4>';
            foreach (\ as \) {
                echo '<p><strong>📖 ' . \['title'] . '</strong> - ' . \['author'] . '</p>';
            }
            echo '</div>';
        } else {
            echo '<div class=\"error\">❌ В кэше нет данных или произошла ошибка</div>';
            echo '<div class=\"result-item\">';
            echo '<p>В реальном проекте здесь были бы данные из Redis.</p>';
            echo '<p>Для демонстрации используется эмуляция работы с Redis.</p>';
            echo '</div>';
        }
        break;

    default:
        echo '<div class=\"error\">❌ Неизвестное действие</div>';
}
?>
