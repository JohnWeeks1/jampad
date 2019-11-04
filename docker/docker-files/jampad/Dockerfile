FROM php:7.3.10-fpm-stretch
RUN apt update && apt upgrade -y
RUN apt install -y git zip unzip mysql-client wget
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install sockets
RUN wget https://getcomposer.org/download/1.9.0/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/bin/composer
