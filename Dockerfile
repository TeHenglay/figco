FROM php:8.4-cli-alpine

WORKDIR /app

RUN apk add --no-cache \
    git curl zip unzip \
    postgresql-dev oniguruma-dev libxml2-dev libpng-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring xml bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN php artisan storage:link || true

EXPOSE 8000

CMD sh -c "php artisan config:cache && php artisan route:cache && php -S 0.0.0.0:$PORT -t public"
