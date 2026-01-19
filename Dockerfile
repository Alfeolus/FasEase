FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /var/www

# Copy composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permission
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
