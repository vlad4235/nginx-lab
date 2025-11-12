FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Копируем composer файлы сначала для кэширования
COPY www/composer.* ./

RUN composer install --no-dev --optimize-autoloader

# Копируем остальные файлы
COPY www/ ./

CMD ["php-fpm"]
