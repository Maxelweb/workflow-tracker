FROM php:7.4-apache-buster
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www
RUN a2enmod rewrite