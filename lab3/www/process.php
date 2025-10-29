<?php
require_once 'db.php';
require_once 'Ticket.php';

// Инициализируем класс Ticket и создаем таблицу
$ticket = new Ticket($pdo);
$ticket->createTable();

// Обрабатываем только POST запросы
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form.html');
    exit();
}

// Получаем и валидируем данные
$name = trim($_POST['name'] ?? '');
$tickets_count = intval($_POST['tickets_count'] ?? 0);
$movie = trim($_POST['movie'] ?? '');
$seat_type = trim($_POST['seat_type'] ?? '');
$has_3d_glasses = isset($_POST['has_3d_glasses']) ? 1 : 0;

// Валидация
$errors = [];
if (empty($name)) $errors[] = "Имя обязательно для заполнения";
if ($tickets_count < 1 || $tickets_count > 10) $errors[] = "Количество билетов должно быть от 1 до 10";
if (empty($movie)) $errors[] = "Выберите фильм";
if (empty($seat_type)) $errors[] = "Выберите тип места";

// Если есть ошибки валидации - возвращаем на форму
if (!empty($errors)) {
    session_start();
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: form.html');
    exit();
}

// Пытаемся сохранить в базу данных
try {
    $ticket_id = $ticket->add($name, $tickets_count, $movie, $has_3d_glasses, $seat_type);
    
    session_start();
    $_SESSION['success_message'] = "Билеты успешно забронированы! Номер заказа: #$ticket_id";
    header('Location: index.php');
    exit();
    
} catch (Exception $e) {
    session_start();
    $_SESSION['form_errors'] = ["Ошибка при сохранении в базу данных: " . $e->getMessage()];
    $_SESSION['form_data'] = $_POST;
    header('Location: form.html');
    exit();
}
?>
