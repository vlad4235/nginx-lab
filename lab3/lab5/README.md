# 🎬 Лабораторная работа №5 – Работа с базой данных MySQL через PHP и Docker

## 🎯 Цель работы
Научиться работать с базой данных MySQL через PHP в Docker-окружении.
Создать таблицу для данных формы бронирования билетов.
Сохранять данные формы в базу данных MySQL.
Выводить данные из базы на странице с помощью PHP.
Использовать классы PHP для работы с таблицей билетов.

## 🏗️ Архитектура проекта
lab5/
├── 🐳 docker-compose.yml # Конфигурация Docker
├── 🐘 Dockerfile # PHP-FPM с расширениями MySQL
├── 📁 www/
│ ├── 📄 index.php # Главная страница с заказами из БД
│ ├── 📄 form.html # Форма бронирования билетов
│ ├── 📄 process.php # Обработчик формы + сохранение в БД
│ ├── 📄 db.php # Подключение к MySQL
│ └── 📄 Ticket.php # Класс для работы с таблицей билетов

text

## 🚀 Запуск проекта
```bash
# Перейти в папку lab5
cd lab5

# Запустить контейнеры
docker-compose up -d
🌐 Доступные сервисы
Сайт: http://localhost:8080

Adminer (управление БД): http://localhost:8081

MySQL (локально): mysql -h 127.0.0.1 -P 3307 -u lab5_user -p lab5_db

🔧 Технологии
🐳 Docker & Docker Compose

🐘 PHP 8.2 FPM + PDO MySQL

🗄️ MySQL 8.0

🖥️ Adminer (веб-интерфейс для БД)

🌐 Nginx (из предыдущих лабораторных)

📊 Структура базы данных
Таблица tickets:

sql
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    tickets_count INT NOT NULL,
    movie VARCHAR(100) NOT NULL,
    has_3d_glasses TINYINT(1) DEFAULT 0,
    seat_type VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
✨ Функциональность
✅ Подключение к MySQL через PDO
✅ Создание таблицы при запуске
✅ Валидация данных формы на сервере
✅ Сохранение заказов в базу данных
✅ Просмотр всех заказов из БД
✅ Обработка ошибок подключения к БД
✅ Автоматическое создание таблицы

🔐 Данные для подключения к БД
php
$host = 'db';           // Имя сервиса в docker-compose
$db   = 'lab5_db';      // Имя базы данных
$user = 'lab5_user';    // Пользователь
$pass = 'lab5_pass';    // Пароль
👨‍💻 Автор
Константинов Владислав Алексеевич
Группа: 3МО-3 🎓
