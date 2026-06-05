FROM php:8.4-cli-alpine

WORKDIR /app

RUN apk add --no-cache \
    git curl zip unzip nodejs npm \
    postgresql-dev oniguruma-dev libxml2-dev libpng-dev libzip-dev \
    font-noto-khmer

RUN docker-php-ext-install pdo pdo_pgsql mbstring xml bcmath gd zip

# Copy Noto Khmer font to app storage for DomPDF
RUN mkdir -p /app/storage/fonts && \
    find /usr/share/fonts -name "*Khmer*" -o -name "*khmer*" 2>/dev/null | head -1 | \
    xargs -I{} cp {} /app/storage/fonts/NotoKhmer.ttf || true

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build

RUN php artisan storage:link || true

EXPOSE 8000

CMD sh -c "php artisan config:cache && php artisan route:cache && php -S 0.0.0.0:$PORT -t public"
