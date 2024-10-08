FROM --platform=linux/amd64 php:8.1.5-apache-buster as development

# Install dependencies & extensions
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) gd

# Install php extension
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    exif \
    pcntl \
    intl \
    opcache

# Clear cache
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Remove Cache
RUN rm -rf /var/cache/apt/* && \
    rm -rf /tmp/*

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# Disable warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable module dan restart apache nya
RUN a2enmod rewrite && \
    service apache2 restart

# Alias codeception
RUN echo 'alias c="vendor/bin/codecept"' >> /etc/bash.bashrc

# ==================================================================================================
FROM development AS deploy

## Uncomment, if you want run in https
# RUN ln -s /etc/apache2/mods-available/ssl.load  /etc/apache2/mods-enabled/ssl.load
# RUN a2enmod headers && a2enmod ssl && a2enmod socache_shmcb && service apache2 restart

COPY . .
COPY ./web/index-prod.php web/index.php
COPY ./.docker/php/php.ini /usr/local/etc/php/php.ini

## Uncomment, if you want run in https
#COPY ./.docker/php/debian-apache/000-default-prod.conf /etc/apache2/sites-available/000-default.conf
COPY ./.docker/php/debian-apache/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN mkdir ./runtime ./web/assets && \
    rm -rf .docker && \
    echo "*\n!.gitignore" | tee ./runtime/.gitignore ./web/assets/.gitignore && \
    chown -R www-data:www-data ./web/.well-known && \
    chown www-data:www-data ./runtime && \
    chgrp www-data ./web/assets && \
    chmod g+w ./web/assets