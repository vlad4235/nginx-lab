<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎬 Покупка билетов в кино</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .radio-group, .checkbox-group { margin: 10px 0; }
        button { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { color: green; padding: 10px; background: #d4edda; border-radius: 4px; }
        .logs { margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>🎬 Покупка билетов в кино</h1>
    
    <?php
    if ($_POST) {
        require 'vendor/autoload.php';
        require 'QueueManager.php';
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'tickets_count' => (int)($_POST['tickets_count'] ?? 1),
            'movie' => $_POST['movie'] ?? '',
            'has_3d_glasses' => isset($_POST['has_3d_glasses']) ? 1 : 0,
            'seat_type' => $_POST['seat_type'] ?? 'standard',
            'timestamp' => date('Y-m-d H:i:s'),
            'order_id' => uniqid('ORDER_')
        ];
        
        try {
            $queue = new QueueManager();
            $queue->publish($data);
            echo '<div class="success">✅ Заказ отправлен в обработку! Номер заказа: ' . $data['order_id'] . '</div>';
        } catch (Exception $e) {
            echo '<div style="color: red;">❌ Ошибка: ' . $e->getMessage() . '</div>';
        }
    }
    ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="name">👤 Ваше имя:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="tickets_count">🎫 Количество билетов:</label>
            <input type="number" id="tickets_count" name="tickets_count" min="1" max="10" value="1" required>
        </div>
        
        <div class="form-group">
            <label for="movie">🎭 Выберите фильм:</label>
            <select id="movie" name="movie" required>
                <option value="">-- Выберите фильм --</option>
                <option value="Аватар: Путь воды">Аватар: Путь воды</option>
                <option value="Оппенгеймер">Оппенгеймер</option>
                <option value="Барби">Барби</option>
                <option value="Стражи Галактики">Стражи Галактики</option>
                <option value="Дюна">Дюна</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>🪑 Тип места:</label>
            <div class="radio-group">
                <label><input type="radio" name="seat_type" value="standard" checked> Стандарт (500 руб.)</label>
            </div>
            <div class="radio-group">
                <label><input type="radio" name="seat_type" value="comfort"> Комфорт (800 руб.)</label>
            </div>
            <div class="radio-group">
                <label><input type="radio" name="seat_type" value="vip"> VIP (1200 руб.)</label>
            </div>
        </div>
        
        <div class="form-group">
            <div class="checkbox-group">
                <label><input type="checkbox" name="has_3d_glasses" value="1"> 🕶️ Нужны 3D очки (+150 руб.)</label>
            </div>
        </div>
        
        <button type="submit">🎫 Купить билеты</button>
    </form>
    
    <div class="logs">
        <h3>📋 Последние заказы:</h3>
        <?php
        if (file_exists('processed_orders.log')) {
            $lines = file('processed_orders.log');
            $recent = array_slice($lines, -5);
            echo '<ul>';
            foreach (array_reverse($recent) as $line) {
                $order = json_decode($line, true);
                if ($order) {
                    echo '<li><strong>' . $order['order_id'] . '</strong> - ' . $order['name'] . ' - ' . $order['movie'] . ' (' . $order['tickets_count'] . ' билет.)</li>';
                }
            }
            echo '</ul>';
        } else {
            echo '<p>Заказов пока нет</p>';
        }
        ?>
    </div>
    
    <div style="margin-top: 20px; padding: 10px; background: #e9ecef; border-radius: 4px;">
        <strong>🐇 RabbitMQ Management:</strong> 
        <a href="http://localhost:15672" target="_blank">http://localhost:15672</a> (guest/guest)
    </div>
</body>
</html>