FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all application files
COPY . .

# Create storage directories
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 10000

# Start server with storage setup
CMD mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache && chmod -R 777 storage && php artisan config:clear && php artisan migrate --force --seed && php artisan serve --host=0.0.0.0 --port=10000
