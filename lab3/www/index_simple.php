<?php
// Простая версия без session_start() для тестирования
require_once __DIR__ . '/autoload.php';

$userInfo = new UserInfo();
$apiClient = new ApiClient();

// Используем куки вместо сессии для простых данных
$lastOrderTime = $_COOKIE['last_order_time'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кинотеатр - Главная (Простая версия)</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .info-section { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .user-info { background: #fff3cd; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 Кинотеатр - Главная страница (Простая версия)</h1>
        
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
                
                <?php if (!empty($lastOrderTime)): ?>
                    <div>
                        <strong>🍪 Последний заказ:</strong><br>
                        <?= htmlspecialchars($lastOrderTime) ?>
                    </div>
                <?php endif; ?>
                
                <div>
                    <strong>🌐 Браузер:</strong><br>
                    <?= htmlspecialchars($userInfo->getBrowserInfo()) ?>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>✅ Система работает!</h2>
            <p>Классы ApiClient и UserInfo успешно загружены.</p>
            <p>Проблема с BOM решена.</p>
        </div>

        <nav>
            <a href="form.html">🎫 Забронировать билеты</a> | 
            <a href="view.php">📋 Посмотреть все заказы</a> |
            <a href="phpinfo.php">🐘 PHP Info</a>
        </nav>
    </div>
</body>
</html>