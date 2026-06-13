FROM php:8.0-fpm

# Cài extension PHP và các tool cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc
WORKDIR /var/www

# Copy mã nguồn Laravel vào container (bao gồm cả hình ảnh trong public)
COPY . .

# Copy entry point script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set quyền cho Laravel
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache /var/www/public \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public

# Expose cổng 80 cho php artisan serve
EXPOSE 80

# Sử dụng entry point script
ENTRYPOINT ["docker-entrypoint.sh"]

