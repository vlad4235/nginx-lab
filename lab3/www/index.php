<?php
// Упрощенная версия без session_start()
require_once __DIR__ . '/autoload.php';

$userInfo = new UserInfo();
$apiClient = new ApiClient();

// Используем куки вместо сессии
$lastOrderName = $_COOKIE['last_order_name'] ?? '';
$lastOrderTime = $_COOKIE['last_order_time'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кинотеатр - Главная</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .info-section { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .user-info { background: #fff3cd; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .success-message { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 Кинотеатр - Главная страница</h1>
        
        <?php if (!empty($lastOrderName)): ?>
            <div class="success-message">
                <h3>✅ Последний заказ:</h3>
                <p><strong>Имя:</strong> <?= htmlspecialchars($lastOrderName) ?></p>
                <p><strong>Время:</strong> <?= htmlspecialchars($lastOrderTime) ?></p>
            </div>
        <?php endif; ?>

        <div class="user-info">
            <h3>ℹ️ Информация о системе</h3>
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
            </div>
        </div>

        <div class="info-section">
            <h2>Добро пожаловать в кинотеатр!</h2>
            <p>Здесь вы можете забронировать билеты на лучшие фильмы.</p>
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