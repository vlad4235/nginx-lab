<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Все заказы</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .order { border: 1px solid #ccc; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Все заказы</h1>
    <a href="index.php">На главную</a> | 
    <a href="form.html">Новый заказ</a>
    
    <?php
    if (file_exists("data.txt")) {
        $lines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines) {
            foreach ($lines as $line) {
                $data = explode(";", $line);
                if (count($data) >= 8) {
                    echo "<div class=\"order\">";
                    echo "<h3>" . $data[1] . "</h3>";
                    echo "<p>Билетов: " . $data[2] . "</p>";
                    echo "<p>Фильм: " . $data[3] . "</p>";
                    echo "<p>Дата: " . $data[4] . "</p>";
                    echo "<p>Место: " . $data[5] . "</p>";
                    echo "</div>";
                }
            }
        } else {
            echo "<p>Заказов нет</p>";
        }
    } else {
        echo "<p>Файл не найден</p>";
    }
    ?>
</body>
</html>
