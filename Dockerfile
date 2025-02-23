# Use the official PHP image with Apache
FROM php:7.4-apache

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Set the working directory
WORKDIR /var/www/html

# Copy the source code into the container
COPY . /var/www/html

# Set the appropriate permissions for uploaded files
RUN chown -R www-data:www-data /var/www/html/uploads

# Enable the Apache mod_rewrite module
RUN a2enmod rewrite

# Copy the custom php.ini for development change it if deploy into production
COPY php-dev.ini /usr/local/etc/php/php.ini

# Expose port 80
EXPOSE 80

# Default command to run in development
CMD ["php", "spark", "serve", "--host=0.0.0.0"]
