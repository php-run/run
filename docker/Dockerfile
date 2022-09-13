FROM php:8.1.2-fpm-alpine AS development

# Update image packages
RUN apk update && apk upgrade

# Install dependencies and development tools, only dependencies installed with pecl need to be enabled manually
RUN apk add --no-cache $PHPIZE_DEPS curl \
    && pecl install xdebug-3.1.2 redis-5.3.6 \
    && docker-php-ext-enable xdebug redis \
    && docker-php-ext-install mysqli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Make the app run as an unprivileged user for additional security
USER www-data
