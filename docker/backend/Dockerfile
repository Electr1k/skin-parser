FROM php:8.3-fpm

# Установка необходимых пакетов и PHP-расширений
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libpq-dev

# Установка PHP-расширений
RUN docker-php-ext-install pdo_pgsql zip mbstring exif

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
ADD ../../backend /var/www/html
WORKDIR /var/www/html

# Настройка прав доступа к директориям приложения
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

