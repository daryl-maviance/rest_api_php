FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install PDO extension for MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copy application files
COPY . .

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

