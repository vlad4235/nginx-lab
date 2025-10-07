<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кинотеатр - Главная</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .session-data { background: #f0f8ff; padding: 15px; margin: 20px 0; border-radius: 8px; }
        .errors { background: #ffe6e6; padding: 15px; margin: 20px 0; border-radius: 8px; color: #d00; }
        .navigation { margin: 20px 0; }
        .navigation a { margin-right: 15px; text-decoration: none; color: #0066cc; }
    </style>
</head>
<body>
    <h1>🎬 Добро пожаловать в кинотеатр!</h1>
    
    <div class="navigation">
        <a href="form.html">🎟️ Заполнить форму заказа</a> | 
        <a href="view.php">📊 Посмотреть все заказы</a>
    </div>

    <?php if(isset(['errors'])): ?>
        <div class="errors">
            <h3>❌ Ошибки:</h3>
            <ul>
                <?php foreach(['errors'] as ): ?>
                    <li><?php echo htmlspecialchars(); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset(['errors']); ?>
    <?php endif; ?>

    <?php if(isset(['form_data'])): ?>
        <div class="session-data">
            <h3>✅ Последний заказ:</h3>
            <ul>
                <li><strong>👤 Имя:</strong> <?php echo htmlspecialchars(['form_data']['name']); ?></li>
                <li><strong>🎟️ Билетов:</strong> <?php echo htmlspecialchars(['form_data']['ticketCount']); ?></li>
                <li><strong>🎬 Фильм:</strong> <?php echo htmlspecialchars(['form_data']['movie']); ?></li>
                <li><strong>📅 Дата:</strong> <?php echo htmlspecialchars(['form_data']['date']); ?></li>
                <li><strong>💺 Место:</strong> <?php echo htmlspecialchars(['form_data']['seatType']); ?></li>
                <li><strong>🎁 Дополнительно:</strong> <?php echo !empty(['form_data']['extras']) ? implode(', ', ['form_data']['extras']) : 'нет'; ?></li>
                <?php if(!empty(['form_data']['comments'])): ?>
                    <li><strong>💬 Комментарий:</strong> <?php echo htmlspecialchars(['form_data']['comments']); ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <?php unset(['form_data']); ?>
    <?php else: ?>
        <p>📝 Заказов пока нет. Заполните форму!</p>
    <?php endif; ?>

    <hr>
    <h2>🐘 Информация о PHP</h2>
    <p><a href="phpinfo.php">Посмотреть phpinfo()</a></p>
</body>
</html>
