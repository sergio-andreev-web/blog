FROM php:8.1-fpm

# Установим зависимости
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev

# Установим расширения PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установим Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создадим рабочую директорию
WORKDIR /var/www

# Скопируем текущий проект в контейнер
COPY . /var/www

# Установим зависимости проекта
RUN composer install

# Изменим права доступа для storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Экспонируем порт 9000 и запускаем сервер
EXPOSE 9000
CMD ["php-fpm"]
