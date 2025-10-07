<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все заказы</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .order { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 8px; }
        .navigation { margin-bottom: 20px; }
        .navigation a { margin-right: 15px; text-decoration: none; color: #0066cc; }
    </style>
</head>
<body>
    <div class="navigation">
        <a href="index.php">🏠 На главную</a> | 
        <a href="form.html">🎟️ Новый заказ</a>
    </div>

    <h1>📊 Все заказы билетов</h1>
    
    <?php
    if (file_exists("data.txt")) {
        \ = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!empty(\)) {
            echo "<div class='orders'>";
            foreach (\ as \) {
                \ = explode(";", \);
                if (count(\) >= 8) {
                    list(\, \, \, \, \, \, \, \) = \;
                    
                    \ = array(
                        'avatar' => 'Аватар: Путь воды',
                        'oppenheimer' => 'Оппенгеймер', 
                        'barbie' => 'Барби',
                        'john_wick' => 'Джон Уик 4'
                    );
                    
                    \ = array(
                        'standard' => 'Стандарт',
                        'comfort' => 'Комфорт',
                        'vip' => 'VIP'
                    );
                    
                    echo "<div class='order'>";
                    echo "<h3>👤 " . htmlspecialchars(\) . "</h3>";
                    echo "<p><strong>🕐 Время заказа:</strong> " . htmlspecialchars(\) . "</p>";
                    echo "<p><strong>🎟️ Билетов:</strong> " . htmlspecialchars(\) . "</p>";
                    echo "<p><strong>🎬 Фильм:</strong> " . (isset(\[\]) ? \[\] : htmlspecialchars(\)) . "</p>";
                    echo "<p><strong>📅 Дата сеанса:</strong> " . htmlspecialchars(\) . "</p>";
                    echo "<p><strong>💺 Тип места:</strong> " . (isset(\[\]) ? \[\] : htmlspecialchars(\)) . "</p>";
                    
                    if (!empty(\)) {
                        \ = explode(',', \);
                        \ = array(
                            '3d_glasses' => '3D очки'
                        );
                        \ = array();
                        foreach (\ as \) {
                            \[] = isset(\[\]) ? \[\] : \;
                        }
                        echo "<p><strong>🎁 Дополнительно:</strong> " . implode(', ', \) . "</p>";
                    }
                    
                    if (!empty(\)) {
                        echo "<p><strong>💬 Комментарий:</strong> " . htmlspecialchars(\) . "</p>";
                    }
                    
                    echo "</div>";
                }
            }
            echo "</div>";
        } else {
            echo "<p>Заказов пока нет.</p>";
        }
    } else {
        echo "<p>Файл с заказами не найден.</p>";
    }
    ?>
</body>
</html>
