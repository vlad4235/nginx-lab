<?php
require_once "db.php";

echo "<!DOCTYPE html>";
echo "<html><head><title>Заказы</title>";
echo "<style>";
echo "body {font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px;}";
echo "table {width: 100%; border-collapse: collapse; margin: 20px 0;}";
echo "th, td {border: 1px solid #ddd; padding: 10px; text-align: left;}";
echo "th {background-color: #007bff; color: white;}";
echo "tr:nth-child(even) {background-color: #f2f2f2;}";
echo "</style>";
echo "</head><body>";
echo "<h1>📋 Все заказы</h1>";

echo "<nav>";
echo "<a href=\"index.php\">🏠 Главная</a> | ";
echo "<a href=\"form.html\">🎫 Бронирование</a>";
echo "</nav>";

try {
    $pdo = getDB();
    
    // Получаем все заказы
    $stmt = $pdo->query("SELECT * FROM tickets ORDER BY created_at DESC");
    $orders = $stmt->fetchAll();
    
    if (empty($orders)) {
        echo "<div style=\"background: #fff3cd; padding: 20px; border-radius: 5px; text-align: center;\">";
        echo "<h3>Заказов пока нет</h3>";
        echo "<p>Будьте первым, кто <a href=\"form.html\">забронирует билеты</a>!</p>";
        echo "</div>";
    } else {
        echo "<table>";
        echo "<tr><th>ID</th><th>Имя</th><th>Билеты</th><th>Фильм</th><th>Тип места</th><th>3D очки</th><th>Комментарий</th><th>Дата заказа</th></tr>";
        
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>" . $order["id"] . "</td>";
            echo "<td>" . htmlspecialchars($order["name"]) . "</td>";
            echo "<td>" . $order["tickets_count"] . "</td>";
            echo "<td>" . htmlspecialchars($order["movie"]) . "</td>";
            echo "<td>" . htmlspecialchars($order["seat_type"]) . "</td>";
            echo "<td>" . ($order["has_3d_glasses"] ? "✅ Да" : "❌ Нет") . "</td>";
            echo "<td>" . htmlspecialchars($order["comment"] ?: "-") . "</td>";
            echo "<td>" . $order["created_at"] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
    
} catch (PDOException $e) {
    echo "<p style=\"color: red;\">Ошибка базы данных: " . $e->getMessage() . "</p>";
}

echo "</body></html>";
?>