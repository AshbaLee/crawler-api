FROM phusion/baseimage:bionic-1.0.0

LABEL maintainer="Ashba Lee<lee.ashba@gmail.com>"

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive

# Start as root
USER root

# Install Software
# Add the "PHP 7" ppa
RUN apt-get install -y software-properties-common \
    && add-apt-repository -y ppa:ondrej/php

RUN echo 'DPkg::options { "--force-confdef"; };' >> /etc/apt/apt.conf

RUN apt-get update -yqq \
    && apt-get install -y --allow-downgrades --allow-remove-essential --allow-change-held-packages \
      php7.4-cli \
      php7.4-common \
      php7.4-curl \
      php7.4-intl \
      php7.4-json \
      php7.4-xml \
      php7.4-mbstring \
      php7.4-mysql \
      php7.4-pgsql \
      php7.4-sqlite \
      php7.4-sqlite3 \
      php7.4-zip \
      php7.4-bcmath \
      php7.4-memcached \
      php7.4-gd \
      php-redis \
      pkg-config \
      libcurl4-openssl-dev \
      libedit-dev \
      libssl-dev \
      php7.4-dev \
      libxml2-dev \
      xz-utils \
      libsqlite3-dev \
      sqlite3 \
      git \
      curl \
      vim \
      nano \
      inetutils-ping \
      postgresql-client \
      apt-utils \
      libzip-dev zip unzip \
    && apt-get clean

# Install composer and add its bin to the PATH
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Add non-root user
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}
ARG USER=ashba
ENV USER ${USER}

RUN groupadd -g ${PGID} ${USER} && \
    useradd -u ${PUID} -g ${USER} -m ${USER} && \
    usermod -p "*" ${USER} -s /bin/bash

# Set Timezone
ARG TZ=UTC
ENV TZ ${TZ}

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Crontab
# COPY ./crontab /etc/cron.d
# RUN chmod -R 644 /etc/cron.d

# Set php version
RUN update-alternatives --set php /usr/bin/php7.4

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Set default work directory
WORKDIR /var/www

# Set default work directory permission
RUN chown ${USER}:${USER} -R /var/www
