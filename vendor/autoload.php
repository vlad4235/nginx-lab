<?php
// Простой автозагрузчик для проекта
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/../www/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Подключаем наши классы
$project_files = ['ApiClient', 'UserInfo'];
foreach ($project_files as $file) {
    $file_path = __DIR__ . '/../www/' . $file . '.php';
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}
?>
