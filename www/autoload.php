<?php
// Упрощенный автозагрузчик для Docker окружения
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Вручную подключаем наши классы
require_once __DIR__ . '/ApiClient.php';
require_once __DIR__ . '/UserInfo.php';
?>
