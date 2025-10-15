<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все заказы</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .order { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 8px; background: #f9f9f9; }
        a { color: #007cba; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Все заказы билетов</h1>
    <a href="http://localhost:8082/index.php">На главную</a> |
    <a href="http://localhost:8082/form.html">Новый заказ</a>
    
    <hr>

    <?php
    if (file_exists("data.txt")) {
        $lines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines) {
            echo "<div>";
            foreach ($lines as $line) {
                $data = explode(";", $line);
                if (count($data) >= 8) {
                    echo "<div class=\"order\">";
                    echo "<h3>" . htmlspecialchars($data[1]) . "</h3>";
                    echo "<p><strong>Время заказа:</strong> " . htmlspecialchars($data[0]) . "</p>";
                    echo "<p><strong>Билетов:</strong> " . htmlspecialchars($data[2]) . "</p>";
                    echo "<p><strong>Фильм:</strong> " . htmlspecialchars($data[3]) . "</p>";
                    echo "<p><strong>Дата сеанса:</strong> " . htmlspecialchars($data[4]) . "</p>";
                    echo "<p><strong>Тип места:</strong> " . htmlspecialchars($data[5]) . "</p>";
                    
                    if (!empty($data[6])) {
                        echo "<p><strong>Дополнительно:</strong> " . htmlspecialchars($data[6]) . "</p>";
                    }
                    
                    if (!empty($data[7])) {
                        echo "<p><strong>Комментарий:</strong> " . htmlspecialchars($data[7]) . "</p>";
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