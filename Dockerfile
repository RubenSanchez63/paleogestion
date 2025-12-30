FROM php:8.4-apache

# 1. Dependencias del sistema
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite


# Instalamos Composer copiándolo desde su imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Por defecto: Intentar instalar dependencias si faltan y arranca Apache!
CMD bash -c "[ ! -d 'vendor' ] && composer install; apache2-foreground"