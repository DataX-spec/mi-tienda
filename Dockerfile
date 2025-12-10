FROM php:8.2-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
COPY . /var/www

# Instalar dependencias de Laravel
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Preparar entorno y base de datos
RUN php -r "file_exists('.env') || copy('.env.example', '.env');" && \
    php artisan key:generate --force && \
    touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan storage:link || true

# Puerto que Render espera
EXPOSE 10000

# Comando final para iniciar Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
