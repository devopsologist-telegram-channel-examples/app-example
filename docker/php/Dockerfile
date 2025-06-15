FROM composer:2.8 AS composer
FROM spiralscout/roadrunner:2025.1 AS roadrunner
FROM mlocati/php-extension-installer:2.8 AS php-extension-installer
FROM php:8.3-cli-bookworm AS dev-php

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=roadrunner /usr/bin/rr /usr/bin/rr
COPY --from=php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

ARG UID=10001
ARG GID=10001

RUN <<EOF
  groupmod --gid=${GID} www-data
  usermod --uid=${UID} --gid=${GID} www-data
EOF

RUN <<EOF
  apt-get update
  apt-get install --no-install-recommends --no-install-suggests -q -y \
          postgresql-client \
          unzip
EOF

RUN <<EOF
  install-php-extensions opcache intl sockets protobuf pdo_pgsql zip
  apt-get remove -q -y \
          ${PHPIZE_DEPS} \
          ${BUILD_DEPENDS}
  apt-get clean
EOF

RUN <<EOF
  echo 'assert.exception = 1' >> /usr/local/etc/php/php.ini
  echo 'date.timezone = Europe/Moscow' >> /usr/local/etc/php/conf.d/project.ini
  echo 'opcache.max_accelerated_files = 20000' >> /usr/local/etc/php/conf.d/project.ini
  echo 'realpath_cache_size = 4096K' >> /usr/local/etc/php/conf.d/project.ini
  echo 'realpath_cache_ttl = 600' >> /usr/local/etc/php/conf.d/project.ini
  echo 'short_open_tag = off' >> /usr/local/etc/php/conf.d/project.ini
EOF

ENV PATH=/var/www/.composer/vendor/bin:$PATH

WORKDIR /app

RUN chown www-data:www-data /app

USER www-data

FROM dev-php AS prod-php

USER root

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

USER www-data

ENV COMPOSER_CACHE_DIR=/tmp/composer/cache

COPY ./composer.json ./composer.lock ./symfony.lock ./

RUN \
    --mount=type=cache,uid=${UID},gid=${GID},target=/tmp/composer/cache \
    composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-progress --no-interaction

COPY --chown=www-data:www-data ./ ./

RUN \
    --mount=type=cache,uid=${UID},gid=${GID},target=/tmp/composer/cache \
    composer dump-autoload --classmap-authoritative --no-dev

RUN bin/console c:c --env=prod

CMD ["sh","-c","bin/console doctrine:migrations:migrate --no-interaction && rr serve -d -c .rr.yaml"]
