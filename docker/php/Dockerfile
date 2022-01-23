FROM php:7.4-fpm

LABEL maintainer="Ashba Lee<lee.ashba@gmail.com>"

ENV DEBIAN_FRONTEND noninteractive

ARG TZ=UTC
ENV TZ ${TZ}

RUN set -x \
    && apt-get update \
    && pecl channel-update pecl.php.net \
    && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends \
    curl \
    zip \
    unzip \
    libzip-dev \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    apt-utils

#Install Puppeteer
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgbm1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libnss3 lsb-release xdg-utils wget libgbm-dev libxshmfence-dev
RUN npm install --global --unsafe-perm puppeteer
RUN chmod -R o+rx /usr/lib/node_modules/puppeteer/.local-chromium

# Install pdo_mysql pdo_pgsql exif pcntl opcache zip gd
RUN docker-php-ext-install -j$(nproc) pdo_mysql exif pcntl opcache zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install redis
# RUN pecl install -o -f redis && docker-php-ext-enable redis

# Use the default production configuration
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Override with custom settings
COPY ./laravel.ini $PHP_INI_DIR/conf.d/
COPY ./xlaravel.pool.conf /usr/local/etc/php-fpm.d/
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Clean up
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && rm /var/log/lastlog /var/log/faillog

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN usermod -u ${PUID} www-data && \
    groupmod -g ${PGID} www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
