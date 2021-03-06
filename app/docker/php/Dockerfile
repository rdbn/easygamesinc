FROM php:7.2-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y \
    openssl \
    unzip \
    zlib1g-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install zip

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc
COPY "memory-limit-php.ini" "/usr/local/etc/php/conf.d/memory-limit-php.ini"

WORKDIR /var/www/wiki