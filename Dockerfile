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

# Copy composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies (allow plugins and ignore platform reqs for build)
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# Copy rest of application
COPY . .

# Run composer scripts
RUN composer dump-autoload --optimize

# Install Node dependencies and build assets
RUN npm install && npm run build

# Create storage directories and set permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Clear config cache
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

# Expose port
EXPOSE 10000

# Run migrations and start server
CMD php artisan migrate --force --seed && php artisan serve --host=0.0.0.0 --port=10000
