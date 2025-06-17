# Use the official PHP 8 FPM image as the base
FROM php:8.1.32-fpm

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libicu-dev

# Install PHP extensions including intl
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Copy your custom php.ini file to override the default configuration
COPY ./php-dev.ini /usr/local/etc/php/php.ini

# Copy the entire project to the working directory
COPY . /var/www/html

# Copy the entrypoint script
COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh

# Set permissions for the entrypoint script
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set permissions for the working directory
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 8080 to the host
EXPOSE 8080

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install CodeIgniter 4 dependencies
# RUN composer install

# Start PHP-FPM server and run spark in development mode
CMD ["php", "spark", "serve", "--host=0.0.0.0"]


# # Use the official PHP image with Apache
# FROM bitnami/php-fpm:latest

# # Install necessary PHP extensions
# RUN apt-get update && apt-get install -y \
#     build-essential \
#     libpng-dev \
#     libjpeg62-turbo-dev \
#     libfreetype6-dev \
#     libmcrypt-dev \
#     libonig-dev \
#     locales \
#     zip \
#     jpegoptim optipng pngquant gifsicle \
#     vim \
#     unzip \
#     git \
#     curl \
#     libzip-dev \
#     # php-intl\
#     libmagickwand-dev --no-install-recommends && \
#     docker-php-ext-configure gd --with-jpeg --with-freetype && \
#     docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip && \
#     pecl install imagick && \
#     docker-php-ext-enable imagick && \
#     docker-php-ext-install intl && \
#     curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
#     apt-get clean && \
#     rm -rf /var/lib/apt/lists/*

# # Set the working directory
# WORKDIR /var/www/html

# # COPY ./conf.d/php.ini /usr/local/etc/php/conf.d/

# # Copy the source code into the container
# COPY . /var/www/html

# # Set the appropriate permissions for uploaded files
# RUN chown -R www-data:www-data /var/www/html/writable/uploads
# # RUN chmod -R 777 /var/www/html

# # Enable the Apache mod_rewrite module
# RUN a2enmod rewrite

# # Copy the custom php.ini for development change it if deploy into production
# COPY php-dev.ini /usr/local/etc/php/php.ini

# # Expose port 8080
# EXPOSE 8080

# # Default command to run in development
# CMD ["php", "spark", "serve", "--host=0.0.0.0"]
