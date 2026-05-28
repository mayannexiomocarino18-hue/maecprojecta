FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN cp .env.example .env
RUN php artisan key:generate
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
RUN mkdir -p storage/logs
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "-c", "export APP_KEY=\"${APP_KEY:-$(php -r 'echo \"base64:\".base64_encode(random_bytes(32));')}\" && export APP_URL=\"${APP_URL:-https://maecprojecta.onrender.com}\" && export LOG_CHANNEL=\"${LOG_CHANNEL:-stderr}\" && php artisan config:clear && php artisan cache:clear && php artisan migrate --force && php artisan db:seed --class=AdminUserAccountSeeder --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
