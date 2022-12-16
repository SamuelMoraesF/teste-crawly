FROM php:8.1

COPY . /data
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /data

RUN apt-get update -y && \
    apt-get install -y unzip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    rm -rf /var/lib/apt/lists/* && \
    composer install -o

ENTRYPOINT [ "/usr/bin/composer", "run" ]