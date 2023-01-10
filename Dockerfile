FROM php:apache
WORKDIR /var/www/html

COPY public/ .
COPY src/ src
EXPOSE 80