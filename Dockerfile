# Usar PHP 8.2 (Base con FPM, lo cual es bueno)
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

# Exponer puerto (esto es solo informativo para Docker, no afecta a Railway)
EXPOSE 80

# === LÍNEA DE COMANDO CORREGIDA ===
# 1. Usamos la variable $PORT de Railway.
# 2. Usamos la forma shell (sin corchetes) para que $PORT se expanda.
# 3. Este comando npm + php es adecuado para un servidor de desarrollo simple.
CMD npm install && npm run build && php -S 0.0.0.0:$PORT -t public