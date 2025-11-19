<?php
require 'vendor/autoload.php';
require 'QueueManager.php';

echo "🎬 Worker для обработки заказов билетов запущен!\n";
echo "🐇 Подключение к RabbitMQ...\n";

try {
    $queue = new QueueManager();
    
    $queue->consume(function($data) {
        echo "\n📥 Получен новый заказ:\n";
        echo "   👤 Имя: " . $data['name'] . "\n";
        echo "   🎫 Билетов: " . $data['tickets_count'] . "\n"; 
        echo "   🎭 Фильм: " . $data['movie'] . "\n";
        echo "   🪑 Место: " . $data['seat_type'] . "\n";
        echo "   🕶️ 3D очки: " . ($data['has_3d_glasses'] ? 'Да' : 'Нет') . "\n";
        echo "   📅 Время: " . $data['timestamp'] . "\n";
        echo "   🔢 ID: " . $data['order_id'] . "\n";
        
        // Имитация обработки заказа
        echo "   ⏳ Обработка заказа...\n";
        sleep(3);
        
        // Сохраняем в лог
        file_put_contents('processed_orders.log', json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        
        // Расчет стоимости
        $prices = [
            'standard' => 500,
            'comfort' => 800, 
            'vip' => 1200
        ];
        
        $total = $prices[$data['seat_type']] * $data['tickets_count'];
        if ($data['has_3d_glasses']) {
            $total += 150 * $data['tickets_count'];
        }
        
        echo "   💰 Общая стоимость: " . $total . " руб.\n";
        echo "   ✅ Заказ успешно обработан!\n";
        echo str_repeat("-", 50) . "\n";
    });
    
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
    sleep(5);
}