<?php
require_once "db.php";

echo "<!DOCTYPE html>";
echo "<html><head><title>Кинотеатр - Главная</title>";
echo "<style>body {font-family: Arial; margin: 50px;}</style>";
echo "</head><body>";
echo "<h1>🎬 Кинотеатр - Главная страница</h1>";

// Проверяем успешное бронирование
if (isset($_GET["success"]) && $_GET["success"] == 1) {
    echo "<div style=\"background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0;\">";
    echo "<h3>✅ Билеты успешно забронированы!</h3>";
    echo "</div>";
}

echo "<p>✅ PHP работает!</p>";
echo "<p><strong>Версия PHP:</strong> " . phpversion() . "</p>";

// Простая проверка MySQL
try {
    $pdo = getDB();
    echo "<p style=\"color: green;\">✅ Подключение к MySQL успешно!</p>";
    
    // Проверяем таблицу
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM tickets");
    $count = $stmt->fetch()["count"];
    echo "<p><strong>Заказов в базе:</strong> " . $count . "</p>";
    
} catch (PDOException $e) {
    echo "<p style=\"color: red;\">❌ Ошибка MySQL: " . $e->getMessage() . "</p>";
}

echo "<nav>";
echo "<a href=\"form.html\">🎫 Бронирование</a> | ";
echo "<a href=\"view.php\">📋 Заказы</a> | ";
echo "<a href=\"test.php\">🐘 Тест PHP</a> | ";
echo "<a href=\"http://localhost:8081\" target=\"_blank\">🗄️ Adminer</a>";
echo "</nav>";

echo "</body></html>";
?>