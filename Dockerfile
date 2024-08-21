# Sử dụng image PHP-FPM với Nginx
FROM php:8.2-fpm
# FROM php:8.2-fpm-alpine

# Cài đặt các extensions cần thiết
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql zip opcache pcntl \
    && pecl install redis
    
# Cài đặt thư viện librdkafka
RUN apt-get install -y librdkafka-dev

# Cài đặt extension rdkafka
RUN pecl install rdkafka && docker-php-ext-enable rdkafka

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Sao chép các tệp vào container
COPY . .

# Set timezone
ENV TZ=Asia/Ho_Chi_Minh
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html/laravel 

# Cài đặt dependencies của Laravel
RUN composer install --no-dev --optimize-autoloader

# Tạo key cho ứng dụng Laravel
RUN php artisan key:generate

# Cấp quyền cho thư mục lưu trữ
RUN chown -R www-data:www-data /var/www/html/laravel/storage /var/www/html/laravel/bootstrap/cache

# Cấu hình PHP-FPM 
COPY ./php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

# Sao chép cấu hình Supervisor
COPY ./supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./supervisor/conf.d/* /etc/supervisor/conf.d/

# Thay đổi CMD để chạy Supervisor
CMD php-fpm && supervisord -c /etc/supervisor/supervisord.conf