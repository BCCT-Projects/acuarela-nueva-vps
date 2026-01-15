# Dockerfile para Acuarela Web Page
FROM php:8.2-apache

# Instalar extensiones necesarias de PHP
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install curl \
    && docker-php-ext-install zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar módulos de Apache necesarios
RUN a2enmod rewrite headers expires

# Configurar Apache para permitir .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Configurar tipos MIME para archivos estáticos
RUN echo "AddType text/css .css" >> /etc/apache2/apache2.conf \
    && echo "AddType application/javascript .js" >> /etc/apache2/apache2.conf \
    && echo "AddType image/svg+xml .svg" >> /etc/apache2/apache2.conf

# Configurar PHP
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "session.save_handler = files" >> /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "session.save_path = /tmp" >> /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "upload_max_filesize = 20M" >> /usr/local/etc/php/conf.d/docker-php-custom.ini \
    && echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/docker-php-custom.ini

# Copiar el código al contenedor
COPY . /var/www/html/

# Copiar configuración personalizada de Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Establecer permisos correctos para archivos estáticos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && find /var/www/html -type f -name "*.css" -exec chmod 644 {} \; \
    && find /var/www/html -type f -name "*.js" -exec chmod 644 {} \; \
    && find /var/www/html -type f -name "*.php" -exec chmod 644 {} \;

# Exponer puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]

