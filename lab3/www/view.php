<?php
// view.php - Просмотр всех заказов
$title = "Просмотр всех заказов";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .order-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .order-table th, .order-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .order-table th { background-color: #f8f9fa; }
        .order-table tr:nth-child(even) { background-color: #f2f2f2; }
        .no-orders { background: #fff3cd; padding: 20px; border-radius: 8px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 <?= $title ?></h1>
        
        <nav>
            <a href="index.php">🏠 Главная</a> | 
            <a href="form.html">🎫 Бронирование</a> | 
            <a href="api.php">🎬 TVMaze API</a>
        </nav>

        <?php
        // Читаем данные из файла
        $filename = 'data.txt';
        if (file_exists($filename) && filesize($filename) > 0) {
            $orders = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            ?>
            <h2>Всего заказов: <?= count($orders) ?></h2>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Время заказа</th>
                        <th>Имя</th>
                        <th>Билетов</th>
                        <th>Фильм</th>
                        <th>Дата сеанса</th>
                        <th>Тип места</th>
                        <th>3D очки</th>
                        <th>Комментарий</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($orders) as $order): 
                        $data = explode(';', $order);
                        if (count($data) >= 8):
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($data[0] ?? '') ?></td>
                            <td><?= htmlspecialchars($data[1] ?? '') ?></td>
                            <td><?= htmlspecialchars($data[2] ?? '') ?></td>
                            <td><?= htmlspecialchars($data[3] ?? '') ?></td>
                            <td><?= htmlspecialchars($data[4] ?? '') ?></td>
                            <td><?= htmlspecialchars($data[5] ?? '') ?></td>
                            <td><?= htmlspecialchars($data[6] ?? '') ?></td>
                            <td><?= htmlspecialchars($data[7] ?? '') ?></td>
                        </tr>
                    <?php 
                        endif;
                    endforeach; ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="no-orders">
                <h2>Заказов пока нет</h2>
                <p>Будьте первым, кто <a href="form.html">забронирует билеты</a>!</p>
            </div>
        <?php } ?>
    </div>
</body>
</html>