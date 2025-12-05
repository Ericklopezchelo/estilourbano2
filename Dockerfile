FROM php:8.2-apache

# 1️⃣ Instalar dependencias PHP y Node.js de forma consolidada
RUN apt-get update && \
    apt-get install -y \
        libzip-dev unzip git curl libpq-dev \
        nodejs npm \
    && docker-php-ext-install pdo_mysql zip bcmath pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3️⃣ Establecer directorio de trabajo
WORKDIR /var/www/html

# 4️⃣ Copiar todo el proyecto al contenedor
COPY . .

# 5️⃣ Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# 6️⃣ Crear carpetas de uploads/imagenes y dar permisos correctos (SOLUCIÓN DE PERMISOS)
RUN mkdir -p public/uploads public/imagenes/barberos \
    && chown -R www-data:www-data storage bootstrap/cache public/uploads public/imagenes/barberos \
    && chmod -R 775 storage bootstrap/cache public/uploads public/imagenes/barberos

# 7️⃣ Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# 8️⃣ Cambiar DocumentRoot a public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# 9️⃣ Exponer puerto
EXPOSE 8080

# 🔟 Arrancar Apache
CMD ["apache2-foreground"]
