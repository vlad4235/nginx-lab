<?php
// Функция для подключения к базе данных
function getDB() {
    $host = "db";
    $dbname = "lab5_db";
    $username = "lab5_user";
    $password = "lab5_pass";
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Создаем таблицу если её нет
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS tickets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                tickets_count INT NOT NULL,
                movie VARCHAR(100) NOT NULL,
                seat_type VARCHAR(50) NOT NULL,
                has_3d_glasses TINYINT(1) DEFAULT 0,
                comment TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        return $pdo;
        
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
?>