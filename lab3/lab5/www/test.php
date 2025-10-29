<?php
require_once "db.php";

echo "<!DOCTYPE html>";
echo "<html><head><title>PHP Test</title>";
echo "<style>";
echo "body {font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px;}";
echo ".success {color: green;}";
echo ".error {color: red;}";
echo "</style>";
echo "</head><body>";
echo "<h1>🐘 Тест PHP и MySQL</h1>";

// Проверяем PHP
echo "<h2>PHP информация:</h2>";
echo "<p><strong>Версия PHP:</strong> " . phpversion() . "</p>";

// Проверяем расширения
echo "<p><strong>Расширения:</strong> ";
if (extension_loaded("pdo_mysql")) {
    echo "<span class=\"success\">✅ pdo_mysql</span>";
} else {
    echo "<span class=\"error\">❌ pdo_mysql</span>";
}
echo "</p>";

// Проверяем MySQL
echo "<h2>Подключение к MySQL:</h2>";
try {
    $pdo = getDB();
    echo "<p class=\"success\">✅ Подключение к MySQL успешно!</p>";
    
    // Проверяем таблицы
    $stmt = $pdo->query("SHOW TABLES");
    echo "<p><strong>Таблицы в базе:</strong></p>";
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
    
    // Проверяем данные в таблице tickets
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM tickets");
    $count = $stmt->fetch()["count"];
    echo "<p><strong>Записей в таблице tickets:</strong> " . $count . "</p>";
    
} catch (PDOException $e) {
    echo "<p class=\"error\">❌ Ошибка подключения: " . $e->getMessage() . "</p>";
}

echo "<h2>🔧 Действия:</h2>";
echo "<ul>";
echo "<li><a href=\"index.php\">На главную</a></li>";
echo "<li><a href=\"form.html\">Забронировать билет</a></li>";
echo "<li><a href=\"view.php\">Посмотреть заказы</a></li>";
echo "<li><a href=\"http://localhost:8081\" target=\"_blank\">Adminer</a></li>";
echo "</ul>";

echo "</body></html>";
?>