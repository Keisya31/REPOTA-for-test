FROM php:8.2-fpm

WORKDIR /var/www/repota-skripsi

RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev

RUN docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl

COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]