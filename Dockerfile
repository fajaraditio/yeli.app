FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \ 
    libzip-dev \
    libicu-dev \
    libonig-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configure GD properly
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

# Install Node.js (for frontend asset compilation)
RUN apt-get update && apt-get install -y curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

ENV npm_config_cache=/tmp/.npm

# Install MySQL client (for database management)
RUN apt-get install -y default-mysql-client

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set recommended PHP.ini settings
COPY php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www