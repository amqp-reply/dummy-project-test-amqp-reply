FROM php:8.1-cli
ARG SHARED_DIR
ARG APP_DIR
RUN apt-get update \
    && apt-get install -y git unzip libicu-dev zlib1g-dev librabbitmq-dev \
    && pecl install amqp \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets amqp

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

COPY ${APP_DIR} /var/www/html
COPY ${SHARED_DIR} /shared
RUN mkdir "/bundle"


RUN composer install --no-interaction --prefer-source --optimize-autoloader --ignore-platform-reqs
EXPOSE 8000
