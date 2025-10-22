<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/autoload.php';

$apiClient = new ApiClient();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    $name = trim($_POST['name'] ?? '');
    $tickets = intval($_POST['tickets'] ?? 0);
    $movie = trim($_POST['movie'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $seat = trim($_POST['seat'] ?? '');
    $glasses = isset($_POST['glasses']) ? 'Да' : 'Нет';
    $comment = trim($_POST['comment'] ?? '');
    
    if (empty($name)) $errors[] = "Имя обязательно для заполнения";
    if ($tickets < 1 || $tickets > 10) $errors[] = "Количество билетов должно быть от 1 до 10";
    if (empty($movie)) $errors[] = "Выберите фильм";
    if (empty($date)) $errors[] = "Выберите дату сеанса";
    if (empty($seat)) $errors[] = "Выберите тип места";
    
    if (empty($errors)) {
        $_SESSION['last_order'] = [
            'name' => htmlspecialchars($name),
            'tickets' => $tickets,
            'movie' => htmlspecialchars($movie),
            'date' => $date,
            'seat' => htmlspecialchars($seat),
            'glasses' => $glasses,
            'comment' => htmlspecialchars($comment),
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        $dataLine = date('Y-m-d H:i:s') . ';' . 
                   htmlspecialchars($name) . ';' . 
                   $tickets . ';' . 
                   htmlspecialchars($movie) . ';' . 
                   $date . ';' . 
                   htmlspecialchars($seat) . ';' . 
                   $glasses . ';' . 
                   htmlspecialchars($comment) . PHP_EOL;
        
        file_put_contents('data.txt', $dataLine, FILE_APPEND | LOCK_EX);
        
        $apiData = $apiClient->searchShows('drama');
        $_SESSION['api_data'] = $apiData;
        
        setcookie("last_order_time", date('Y-m-d H:i:s'), time() + 3600, "/");
        setcookie("user_session", session_id(), time() + 3600, "/");
        
        $_SESSION['success_message'] = "Билеты успешно забронированы!";
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: form.html');
        exit();
    }
} else {
    header('Location: form.html');
    exit();
}
