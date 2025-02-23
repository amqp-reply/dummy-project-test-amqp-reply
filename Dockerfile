FROM php:8.1-cli
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
COPY ./shared /shared
COPY ./entrypoint.sh /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
