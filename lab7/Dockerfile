FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    && docker-php-ext-install sockets \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Копируем зависимости
COPY composer.json ./

# Устанавливаем зависимости
RUN composer install --no-dev --no-scripts

# Копируем исходный код
COPY www/ ./

# Оптимизируем автозагрузку
RUN composer dump-autoload --optimize

CMD ["php-fpm"]
