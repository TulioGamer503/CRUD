# 1. Usar la imagen oficial de PHP con Apache
FROM php:8.2-apache

# 2. Instalar extensiones necesarias de PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 3. Copiar el código de la aplicación al contenedor
COPY html/ /var/www/html/

# 4. Configurar permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# 5. Exponer el puerto 80
EXPOSE 80
