# Base image: PHP 7.4 with Apache
FROM php:7.4-apache

USER root

# Set the ServerName directive globally to suppress warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    libmagickwand-dev \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    bz2 \
    intl \
    bcmath \
    opcache \
    calendar

# Enable imagick if necessary
# RUN pecl install imagick
RUN docker-php-ext-enable imagick

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers

# Restart Apache to apply the mod_rewrite changes
RUN service apache2 restart

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN composer self-update

# Set up document root and configure Apache
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Set up the user and group, only if they don't already exist
ARG user=appuser
ARG group=appuser
ARG uid=1000
ARG gid=1000
RUN getent group ${group} || groupadd -g ${gid} ${group}
RUN id -u ${user} &>/dev/null || useradd -u ${uid} -g ${group} -s /bin/sh -m ${user}

# Set permissions for the web directory
COPY . /var/www/html
WORKDIR /var/www/html

USER root
RUN composer update --ignore-platform-reqs
RUN composer install --ignore-platform-reqs
RUN chown -R www-data:${uid} /var/www/html
RUN chmod -R 775 /var/www/html

# Switch to non-root user
USER ${uid}:${gid}

# Expose port 80 for the web server
EXPOSE 80
