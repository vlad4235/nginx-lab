🎬 Лабораторная работа №6 — Изучение нереляционных баз данных
🎯 Цель работы
Научиться работать с современными нереляционными базами данных (Redis, Elasticsearch, ClickHouse) через HTTP API с помощью GuzzleClient. Изучить принципы работы с ключ-значение хранилищами, поисковыми системами и аналитическими базами данных в Docker-окружении.

🏗️ Архитектура проекта
lab6/
├── 🐳 docker-compose.yml      # Конфигурация Docker окружения
├── 🐘 Dockerfile              # PHP-FPM с расширениями
├── 📁 www/
│   ├── 📄 index.php           # Главная страница с примерами
│   ├── 📄 RedisExample.php    # Класс для работы с Redis
│   ├── 📄 ElasticExample.php  # Класс для работы с Elasticsearch
│   ├── 📄 ClickhouseExample.php # Класс для работы с ClickHouse
│   ├── 📄 ClientFactory.php   # Фабрика HTTP-клиентов
│   ├── 📁 Helpers/
│   │   └── 📄 ClientFactory.php # Фабрика для GuzzleClient
│   └── 📄 composer.json       # Зависимости PHP
├── 📄 nginx.conf              # Конфигурация Nginx
└── 📄 README.md               # Документация

🚀 Запуск проекта
# Перейти в папку lab6
cd lab6

# Запустить контейнеры
docker-compose up -d

# Ждать полной инициализации (30 секунд)
docker-compose logs -f

🌐 Доступные сервисы
🌐 Веб-сайт с примерами: http://localhost:8080

🔴 Redis Commander: http://localhost:8081

🔍 Elasticsearch: http://localhost:9200

⚡️ ClickHouse: http://localhost:8123

🔧 Технологии
🐳 Docker & Docker Compose

🐘 PHP 8.2 FPM + GuzzleHTTP

🔴 Redis 7 + Redis Commander

🔍 Elasticsearch 8.10.2

⚡️ ClickHouse 24.3

🌐 Nginx

📦 Composer

📊 Описание баз данных
🔴 Redis - Key-Value хранилище
- Хранение данных в памяти
- Быстрый доступ по ключу
- Использование для кэширования и сессий

🔍 Elasticsearch - Поисковая система
- Полнотекстовый поиск
- Индексация документов
- REST API для запросов

⚡️ ClickHouse - Аналитическая СУБД
- Колоночное хранение
- Высокая производительность для аналитики
- SQL-подобный синтаксис

✨ Функциональность
✅ Взаимодействие с Redis через HTTP API
✅ Индексация документов в Elasticsearch
✅ Полнотекстовый поиск в Elasticsearch
✅ Выполнение SQL запросов в ClickHouse
✅ Создание таблиц в ClickHouse
✅ Обработка ошибок при работе с API
✅ Автозагрузка классов через Composer PSR-4

💻 Примеры использования
🔴 Redis - Работа с ключ-значение
php
\ = new RedisExample();
\->setValue('user:101', ['name' => 'Alice', 'age' => 25]);
\ = \->getValue('user:101');

🔍 Elasticsearch - Поиск и индексация
php
\ = new ElasticExample();
\->indexDocument('books', 1, [
    'title' => '1984', 
    'author' => 'George Orwell'
]);
\ = \->search('books', ['match' => ['author' => 'Orwell']]);

⚡️ ClickHouse - Аналитические запросы
php
\ = new ClickhouseExample();
\->createTable('analytics');
\ = \->query('SELECT count() FROM system.tables');

🔐 Настройки подключения
php
// Redis
Redis: redis:6379
Redis HTTP: redis-commander:8081

// Elasticsearch
http://elasticsearch:9200/

// ClickHouse
http://clickhouse:8123/

📚 Классы и методы
🔧 ClientFactory
- make(string \): Client - создает HTTP клиент

🔴 RedisExample
- setValue(string \, mixed \): string
- getValue(string \): string

🔍 ElasticExample
- createIndex(string \): string
- indexDocument(string \, string \, array \): string
- search(string \, array \): string

⚡️ ClickhouseExample
- query(string \): string
- createTable(string \): string

🐛 Логирование и отладка
# Просмотр логов всех сервисов
docker-compose logs

# Логи конкретного сервиса
docker-compose logs nginx
docker-compose logs php
docker-compose logs elasticsearch

# Проверка статуса контейнеров
docker-compose ps

🛠️ Устранение неисправностей
❌ Elasticsearch не запускается
- Проверить объем памяти: требуется минимум 512MB
- Посмотреть логи: docker-compose logs elasticsearch

❌ Redis недоступен
- Проверить подключение: telnet redis 6379
- Открыть веб-интерфейс: http://localhost:8081

❌ ClickHouse не отвечает
- Проверить порты: netstat -an | findstr 8123
- Тестовый запрос: curl http://localhost:8123

👨‍💻 Автор
Константинов Владислав Алексеевич
Группа: 3МО-3 🎓



