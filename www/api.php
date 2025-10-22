<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/autoload.php';

$apiClient = new ApiClient();
$userInfo = new UserInfo();

$actionShows = $apiClient->searchShows('action');
$comedyShows = $apiClient->searchShows('comedy');
$dramaShows = $apiClient->searchShows('drama');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API TVMaze - Кинотеатр</title>
    <style>
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .category-section { margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 10px; }
        .movie-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .movie-card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .movie-card img { width: 100%; height: 300px; object-fit: cover; border-radius: 5px; }
        .api-info { background: #e8f4fd; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 TVMaze API - Каталог сериалов</h1>
        
        <div class="api-info">
            <h3>ℹ️ Информация о API</h3>
            <p><strong>API:</strong> TVMaze (https://api.tvmaze.com)</p>
            <p><strong>Функция:</strong> Поиск информации о сериалах</p>
            <p><strong>Регистрация:</strong> Не требуется</p>
            <p><strong>Лимиты:</strong> Без ограничений для некоммерческого использования</p>
        </div>

        <nav>
            <a href="index.php">🏠 Главная</a> | 
            <a href="form.html">🎫 Бронирование</a> | 
            <a href="view.php">📋 Заказы</a>
        </nav>

        <div class="category-section">
            <h2>💥 Экшн сериалы</h2>
            <?php if (isset($actionShows['error'])): ?>
                <div class="error">
                    <p>Ошибка при загрузке данных: <?= htmlspecialchars($actionShows['error']) ?></p>
                    <p>Показываем демо-данные</p>
                </div>
            <?php endif; ?>
            <div class="movie-grid">
                <?php 
                $showsToDisplay = isset($actionShows['error']) ? $apiClient->getFallbackData() : array_slice($actionShows, 0, 4);
                foreach ($showsToDisplay as $item): 
                    $show = $item['show'] ?? $item;
                ?>
                    <div class="movie-card">
                        <?php if (isset($show['image']['medium'])): ?>
                            <img src="<?= htmlspecialchars($show['image']['medium']) ?>" alt="<?= htmlspecialchars($show['name']) ?>">
                        <?php else: ?>
                            <div style="background: #f0f0f0; height: 300px; display: flex; align-items: center; justify-content: center; color: #666;">
                                🎬 Нет изображения
                            </div>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($show['name'] ?? 'Unknown') ?></h3>
                        <?php if (isset($show['genres'])): ?>
                            <p><strong>Жанры:</strong> <?= htmlspecialchars(implode(', ', $show['genres'])) ?></p>
                        <?php endif; ?>
                        <?php if (isset($show['rating']['average'])): ?>
                            <p><strong>Рейтинг:</strong> ⭐ <?= htmlspecialchars($show['rating']['average']) ?>/10</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="category-section">
            <h2>😂 Комедийные сериалы</h2>
            <?php if (isset($comedyShows['error'])): ?>
                <div class="error">
                    <p>Ошибка при загрузке данных: <?= htmlspecialchars($comedyShows['error']) ?></p>
                </div>
            <?php endif; ?>
            <div class="movie-grid">
                <?php 
                $showsToDisplay = isset($comedyShows['error']) ? [] : array_slice($comedyShows, 0, 4);
                foreach ($showsToDisplay as $item): 
                    $show = $item['show'] ?? $item;
                ?>
                    <div class="movie-card">
                        <?php if (isset($show['image']['medium'])): ?>
                            <img src="<?= htmlspecialchars($show['image']['medium']) ?>" alt="<?= htmlspecialchars($show['name']) ?>">
                        <?php else: ?>
                            <div style="background: #f0f0f0; height: 300px; display: flex; align-items: center; justify-content: center; color: #666;">
                                🎬 Нет изображения
                            </div>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($show['name'] ?? 'Unknown') ?></h3>
                        <?php if (isset($show['genres'])): ?>
                            <p><strong>Жанры:</strong> <?= htmlspecialchars(implode(', ', $show['genres'])) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="category-section">
            <h2>🎭 Драматические сериалы</h2>
            <?php if (isset($dramaShows['error'])): ?>
                <div class="error">
                    <p>Ошибка при загрузке данных: <?= htmlspecialchars($dramaShows['error']) ?></p>
                </div>
            <?php endif; ?>
            <div class="movie-grid">
                <?php 
                $showsToDisplay = isset($dramaShows['error']) ? [] : array_slice($dramaShows, 0, 4);
                foreach ($showsToDisplay as $item): 
                    $show = $item['show'] ?? $item;
                ?>
                    <div class="movie-card">
                        <?php if (isset($show['image']['medium'])): ?>
                            <img src="<?= htmlspecialchars($show['image']['medium']) ?>" alt="<?= htmlspecialchars($show['name']) ?>">
                        <?php else: ?>
                            <div style="background: #f0f0f0; height: 300px; display: flex; align-items: center; justify-content: center; color: #666;">
                                🎬 Нет изображения
                            </div>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($show['name'] ?? 'Unknown') ?></h3>
                        <?php if (isset($show['genres'])): ?>
                            <p><strong>Жанры:</strong> <?= htmlspecialchars(implode(', ', $show['genres'])) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="api-info">
            <h3>🔧 Техническая информация</h3>
            <p><strong>Класс ApiClient:</strong> Обрабатывает HTTP запросы к TVMaze API</p>
            <p><strong>Класс UserInfo:</strong> Собирает информацию о пользователе и системе</p>
            <p><strong>Автозагрузка:</strong> Упрощенная автозагрузка классов через autoload.php</p>
            <p><strong>Куки:</strong> Сохранение времени последнего заказа</p>
        </div>
    </div>
</body>
</html>