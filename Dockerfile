FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev

RUN docker-php-ext-install pdo_mysql mbstring bcmath gd zip intl

WORKDIR /var/www/repota-skripsi

COPY composer.json composer.lock ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD php artisan migrate --seed --force && php artisan serve --host=0.0.0.0 --port=8000