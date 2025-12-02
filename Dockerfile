# Usar PHP 8.2
FROM php:8.2

# Instalar Node.js (npm) para la compilación de Vite
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Instalar dependencias y extensiones necesarias (PostgreSQL)
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev \
    && docker-php-ext-install pdo_mysql zip bcmath \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto
COPY . .

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Dar permisos correctos a storage y cache
RUN chmod -R 775 storage bootstrap/cache

# Exponer puerto 80 para Render
EXPOSE 80

# ✅ CMD FINAL: Instala dependencias de Node, compila (Vite) y luego inicia el servidor.
CMD npm install && npm run build && php -S 0.0.0.0:80 -t public

