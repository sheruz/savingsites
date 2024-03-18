FROM php:8.0-apache

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Set document root to CodeIgniter app
WORKDIR /var/www/html
RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd imagick intl zip mysqli redis
RUN  apt-get update -y && apt-get install vim -y

RUN a2enmod ssl
RUN a2enmod rewrite


# Expose port 80 and 443
EXPOSE 80
EXPOSE 443

CMD ["apache2-foreground"]
