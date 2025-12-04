# Cambiar la primera línea
FROM php:8.2-apache

# Instalar Node.js para Vite
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Instalar dependencias PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev \
    && docker-php-ext-install pdo_mysql zip bcmath pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Exponer puerto
EXPOSE 8080

# Apache ya arranca automáticamente
CMD ["apache2-foreground"]
