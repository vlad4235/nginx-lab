<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/autoload.php';

$userInfo = new UserInfo();
$apiClient = new ApiClient();

if (!isset($_SESSION['api_data'])) {
    $_SESSION['api_data'] = $apiClient->searchShows('action');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кинотеатр - Главная</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .order-info { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .api-section { background: #e8f4fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .user-info { background: #fff3cd; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .movie-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
        .movie-card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: white; }
        .movie-card img { max-width: 100%; height: auto; border-radius: 5px; }
        .success-message { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 Кинотеатр - Главная страница</h1>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <div class="user-info">
            <h3>ℹ️ Информация о системе и пользователе</h3>
            <div class="info-grid">
                <?php
                $info = $userInfo->getInfo();
                foreach ($info as $key => $value): 
                ?>
                    <div>
                        <strong><?= htmlspecialchars($key) ?>:</strong><br>
                        <?= htmlspecialchars($value) ?>
                    </div>
                <?php endforeach; ?>
                
                <?php if (isset($_COOKIE['last_order_time'])): ?>
                    <div>
                        <strong>🍪 Последний заказ:</strong><br>
                        <?= htmlspecialchars($_COOKIE['last_order_time']) ?>
                    </div>
                <?php endif; ?>
                
                <div>
                    <strong>🌐 Браузер:</strong><br>
                    <?= htmlspecialchars($userInfo->getBrowserInfo()) ?>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['last_order'])): ?>
        <div class="order-info">
            <h2>Ваш последний заказ:</h2>
            <p><strong>Имя:</strong> <?= htmlspecialchars($_SESSION['last_order']['name']) ?></p>
            <p><strong>Билетов:</strong> <?= htmlspecialchars($_SESSION['last_order']['tickets']) ?></p>
            <p><strong>Фильм:</strong> <?= htmlspecialchars($_SESSION['last_order']['movie']) ?></p>
            <p><strong>Дата:</strong> <?= htmlspecialchars($_SESSION['last_order']['date']) ?></p>
            <p><strong>Место:</strong> <?= htmlspecialchars($_SESSION['last_order']['seat']) ?></p>
            <p><strong>3D очки:</strong> <?= htmlspecialchars($_SESSION['last_order']['glasses']) ?></p>
            <p><strong>Комментарий:</strong> <?= htmlspecialchars($_SESSION['last_order']['comment']) ?></p>
            <p><strong>Время заказа:</strong> <?= htmlspecialchars($_SESSION['last_order']['timestamp']) ?></p>
        </div>
        <?php else: ?>
        <div class="order-info">
            <p>У вас еще нет заказов. <a href="form.html">Забронируйте билеты!</a></p>
        </div>
        <?php endif; ?>

        <div class="api-section">
            <h2>🎭 Популярные сериалы (данные из TVMaze API)</h2>
            <p><em>Данные загружаются из публичного API в реальном времени</em></p>
            
            <?php if (isset($_SESSION['api_data']) && is_array($_SESSION['api_data'])): ?>
                <?php if (isset($_SESSION['api_data']['error'])): ?>
                    <div class="error">
                        <p>Ошибка при загрузке данных из API: <?= htmlspecialchars($_SESSION['api_data']['error']) ?></p>
                        <p>Показываем демо-данные</p>
                    </div>
                    <?php 
                    $showsToDisplay = $apiClient->getFallbackData();
                    $_SESSION['api_data'] = $showsToDisplay;
                    ?>
                <?php endif; ?>
                
                <div class="movie-grid">
                    <?php foreach ($_SESSION['api_data'] as $item): 
                        $show = $item['show'] ?? $item;
                    ?>
                        <div class="movie-card">
                            <?php if (isset($show['image']['medium'])): ?>
                                <img src="<?= htmlspecialchars($show['image']['medium']) ?>" 
                                     alt="<?= htmlspecialchars($show['name'] ?? 'Unknown') ?>">
                            <?php else: ?>
                                <div style="background: #f0f0f0; height: 200px; display: flex; align-items: center; justify-content: center; color: #666;">
                                    🎬 Нет изображения
                                </div>
                            <?php endif; ?>
                            
                            <h4><?= htmlspecialchars($show['name'] ?? 'Unknown') ?></h4>
                            
                            <?php if (isset($show['genres']) && is_array($show['genres'])): ?>
                                <p><small><strong>Жанры:</strong> <?= htmlspecialchars(implode(', ', $show['genres'])) ?></small></p>
                            <?php endif; ?>
                            
                            <?php if (isset($show['rating']['average'])): ?>
                                <p><small><strong>⭐ Рейтинг:</strong> <?= htmlspecialchars($show['rating']['average']) ?>/10</small></p>
                            <?php endif; ?>
                            
                            <?php if (isset($show['premiered'])): ?>
                                <p><small><strong>📅 Премьера:</strong> <?= htmlspecialchars(substr($show['premiered'], 0, 4)) ?></small></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Не удалось загрузить данные из API.</p>
            <?php endif; ?>
        </div>

        <nav>
            <a href="form.html">🎫 Забронировать билеты</a> | 
            <a href="view.php">📋 Посмотреть все заказы</a> |
            <a href="api.php">🎬 TVMaze API</a> |
            <a href="phpinfo.php">🐘 PHP Info</a>
        </nav>
    </div>
</body>
</html>