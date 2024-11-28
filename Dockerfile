# Use the official PHP 8.2 image with FPM
FROM php:8.2-fpm

# Update system packages and install necessary dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    openssl \
    zip \
    unzip \
    git \
    curl
RUN docker-php-ext-install pdo mbstring pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . .
RUN composer install
# Install Node.js (for frontend scaffolding)
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

CMD php artisan serve --host=0.0.0.0

# Expose PHP-FPM port
EXPOSE 9100

