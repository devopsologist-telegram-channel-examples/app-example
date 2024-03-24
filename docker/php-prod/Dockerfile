FROM composer:2.7 as composer
FROM spiralscout/roadrunner:2023.3 AS roadrunner
FROM php:8.3-cli-bookworm

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=roadrunner /usr/bin/rr /usr/bin/rr

ARG UID=10000
ARG GID=10000

RUN set -xe \
 && apt-get update && apt-get install --no-install-recommends --no-install-suggests -q -y \
        gnupg2 \
        libicu-dev \
        libzip-dev \
        unzip \
        $PHPIZE_DEPS \
 && chown www-data:www-data /var/www \
 && groupmod --gid=${GID} www-data \
 && usermod --uid=${UID} --gid=${GID} www-data \
 && docker-php-ext-enable \
        opcache \
 && docker-php-ext-install \
        intl \
        sockets \
        zip \
 && echo 'assert.exception = 1' >> /usr/local/etc/php/php.ini \
 && echo 'date.timezone = Europe/Moscow' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'opcache.max_accelerated_files = 20000' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'realpath_cache_size = 4096K' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'realpath_cache_ttl = 600' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'short_open_tag = off' >> /usr/local/etc/php/php.ini \
 && apt-get clean \
 && apt-get remove -q -y \
        libicu-dev \
        libzip-dev \
        $PHPIZE_DEPS

WORKDIR /app

ENV PATH /var/www/.composer/vendor/bin:$PATH
ENV COMPOSER_CACHE_DIR="/tmp/composer/cache"

COPY --chown=www-data:www-data ./composer.json ./composer.lock ./symfony.lock ./

RUN chown www-data:www-data /app \
 && mkdir -p "/tmp/composer/cache" \
 && chown www-data:www-data /tmp/composer/cache

USER www-data

RUN \
    --mount=type=cache,target=/tmp/composer/cache/ \
    composer install --no-dev --no-autoloader --prefer-dist --no-progress --no-interaction

COPY --chown=www-data:www-data ./ ./

RUN composer dump-autoload --classmap-authoritative --no-dev && composer dump-env prod && bin/console c:c

CMD rr serve -d -c ./docker/php-prod/.rr.yaml
