# Gunakan image PHP resmi + ekstensi yang dibutuhkan
FROM php:8.3

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file ke container
COPY . .

# Install dependensi Laravel
RUN composer install --optimize-autoloader --no-dev

# Set permission Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Cache konfigurasi dan buat symlink storage
RUN php artisan config:cache && php artisan storage:link || true

# Expose port 8000
EXPOSE 8000

# Jalankan server Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
