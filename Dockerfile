# PHP 8.3 FPM
FROM php:8.3-fpm

# Dependencias y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring tokenizer xml zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el proyecto
WORKDIR /var/www/html
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-interaction --optimize-autoloader

# Expone el puerto PHP-FPM
EXPOSE 9000

# Comando para iniciar PHP-FPM
CMD ["php-fpm"]
