<?php
// Включаем буферизацию вывода в самом начале
if (ob_get_level() == 0) ob_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Получаем данные из формы
    $name = $_POST["name"] ?? "";
    $tickets = $_POST["tickets"] ?? "";
    $movie = $_POST["movie"] ?? "";
    $seat = $_POST["seat"] ?? "";
    $glasses = isset($_POST["glasses"]) ? 1 : 0;
    $comment = $_POST["comment"] ?? "";
    
    // Валидация
    $errors = [];
    if (empty($name)) $errors[] = "Имя обязательно";
    if (empty($tickets) || $tickets < 1 || $tickets > 10) $errors[] = "Количество билетов должно быть от 1 до 10";
    if (empty($movie)) $errors[] = "Выберите фильм";
    if (empty($seat)) $errors[] = "Выберите тип места";
    
    if (empty($errors)) {
        try {
            // Сохраняем в базу данных
            $pdo = getDB();
            
            $stmt = $pdo->prepare("
                INSERT INTO tickets (name, tickets_count, movie, seat_type, has_3d_glasses, comment) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([$name, $tickets, $movie, $seat, $glasses, $comment]);
            
            // Сохраняем в куки информацию о заказе
            setcookie("last_order_name", $name, time() + 86400, "/");
            setcookie("last_order_time", date("Y-m-d H:i:s"), time() + 86400, "/");
            
            // Очищаем буфер и перенаправляем
            ob_end_clean();
            header("Location: index.php?success=1");
            exit;
            
        } catch (PDOException $e) {
            // Очищаем буфер и показываем ошибку
            ob_end_clean();
            echo "<h1>Ошибка сохранения</h1>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "<a href=\"form.html\">Вернуться к форме</a>";
            exit;
        }
    } else {
        // Очищаем буфер и показываем ошибки валидации
        ob_end_clean();
        echo "<!DOCTYPE html><html><head><title>Ошибки валидации</title></head><body>";
        echo "<h1>Ошибки валидации:</h1>";
        foreach ($errors as $error) {
            echo "<p style=\"color: red;\">" . $error . "</p>";
        }
        echo "<a href=\"form.html\">Вернуться к форме</a>";
        echo "</body></html>";
        exit;
    }
} else {
    // Очищаем буфер и перенаправляем на форму
    ob_end_clean();
    header("Location: form.html");
    exit;
}
?>