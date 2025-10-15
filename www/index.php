<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Кинотеатр - Главная</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .data { background: #f0f8ff; padding: 15px; margin: 20px 0; border-radius: 8px; }
        .error { background: #ffe6e6; padding: 15px; margin: 20px 0; border-radius: 8px; color: #d00; }
        a { color: #007cba; text-decoration: none; margin: 0 10px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Кинотеатр - Главная страница</h1>

    <div>
        <a href="http://localhost:8082/form.html">Заполнить форму заказа</a> |
        <a href="http://localhost:8082/view.php">Все заказы</a>
    </div>

    <hr>

    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="error">
            <h3>Ошибки в форме:</h3>
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['form_data']) && !empty($_SESSION['form_data'])): ?>
        <?php $data = $_SESSION['form_data']; ?>
        <div class="data">
            <h3>Последний заказ:</h3>
            <p><strong>Имя:</strong> <?= $data['name'] ?></p>
            <p><strong>Билетов:</strong> <?= $data['ticketCount'] ?></p>
            <p><strong>Фильм:</strong> <?= $data['movie'] ?></p>
            <p><strong>Дата сеанса:</strong> <?= $data['date'] ?></p>
            <p><strong>Тип места:</strong> <?= $data['seatType'] ?></p>
            
            <?php if (!empty($data['extras'])): ?>
                <p><strong>Дополнительно:</strong> <?= implode(', ', $data['extras']) ?></p>
            <?php else: ?>
                <p><strong>Дополнительно:</strong> нет</p>
            <?php endif; ?>
            
            <?php if (!empty($data['comments'])): ?>
                <p><strong>Комментарий:</strong> <?= $data['comments'] ?></p>
            <?php endif; ?>
        </div>
        <?php unset($_SESSION['form_data']); ?>
    <?php else: ?>
        <p>Заказов пока нет. Заполните форму заказа!</p>
    <?php endif; ?>

    <hr>
    <p><a href="http://localhost:8082/phpinfo.php">Информация о PHP</a></p>
</body>
</html>