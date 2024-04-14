FROM composer:2.7 as composer
FROM spiralscout/roadrunner:2024.1 AS roadrunner
FROM mlocati/php-extension-installer:2.2 as php-extension-installer
FROM php:8.3-cli-bookworm as builder

ARG UID=10001
ARG GID=10001

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=roadrunner /usr/bin/rr /usr/bin/rr
COPY --from=php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -q -y \
            unzip \
 && install-php-extensions opcache intl sockets zip \
 && rm /usr/bin/install-php-extensions \
 && apt-get clean  \
 && apt-get remove -q -y \
            $PHPIZE_DEPS \
            $BUILD_DEPENDS \
 && echo 'date.timezone = Europe/Moscow' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'opcache.max_accelerated_files = 20000' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'realpath_cache_size = 4096K' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'realpath_cache_ttl = 600' >> /usr/local/etc/php/conf.d/project.ini \
 && echo 'short_open_tag = off' >> /usr/local/etc/php/php.ini \
 && groupmod --gid=${GID} www-data \
 && usermod --uid=${UID} --gid=${GID} www-data

WORKDIR /app

ENV COMPOSER_CACHE_DIR="/tmp/composer/cache"

COPY ./composer.json ./composer.lock ./symfony.lock ./

RUN chown www-data:www-data /app

USER www-data

RUN \
    --mount=type=cache,uid=${UID},gid=${GID},target=/tmp/composer/cache \
    composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-progress --no-interaction

COPY --chown=www-data:www-data ./ ./

RUN composer dump-autoload --classmap-authoritative --no-dev \
 && composer dump-env prod \
 && bin/console c:c

CMD rr serve -d -c ./docker/php-prod/.rr.yaml