FROM php:7.4-apache
# Instalar Git
RUN apt-get update && apt-get install -y git
# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql
# Activar mod_rewrite
RUN a2enmod rewrite
# Reiniciar Apache para aplicar cambios
RUN service apache2 restart
# Instala composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer