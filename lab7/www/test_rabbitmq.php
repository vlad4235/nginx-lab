<?php
require 'vendor/autoload.php';

try {
    $connection = new PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    
    echo "✅ Подключение к RabbitMQ успешно!\n";
    echo "📊 Статистика:\n";
    echo "   - Хост: rabbitmq\n";
    echo "   - Порт: 5672\n"; 
    echo "   - Пользователь: guest\n";
    
    $channel->close();
    $connection->close();
    
} catch (Exception $e) {
    echo "❌ Ошибка подключения к RabbitMQ: " . $e->getMessage() . "\n";
    echo "🔧 Проверьте:\n";
    echo "   - Запущен ли контейнер RabbitMQ\n";
    echo "   - Доступен ли порт 5672\n";
    echo "   - Правильные ли credentials\n";
}