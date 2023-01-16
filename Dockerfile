FROM php:apache
WORKDIR /var/www/html

COPY public/ .
COPY src/ src
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql
EXPOSE 80