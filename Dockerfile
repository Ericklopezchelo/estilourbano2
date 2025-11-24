# Usar PHP 8.2
FROM php:8.2

# Instalar dependencias y extensiones necesarias, incluyendo las de PostgreSQL
# NOTA: Esta sintaxis es correcta para instalar pdo_pgsql sin errores de 'Unknown Instruction: &&'
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev \
    && docker-php-ext-install pdo_mysql zip bcmath \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Establecer directorio de trabajo
WORKDIR /var/www/html
# ... (El resto del Dockerfile es el mismo) ...
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

# 1. 🛑 REVERSIÓN DE MIGRACIÓN: Cambiar el CMD de vuelta a la normalidad
# 2. ✅ COMPILACIÓN DE ASSETS: Compilar los activos de Vite antes de iniciar el servidor
# NOTA: Esto solucionará la falta de estilos (CSS) que viste.
CMD php artisan vite:build && php -S 0.0.0.0:80 -t public