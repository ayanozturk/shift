FROM php:7.4-apache

RUN apt-get update -qq  \
 && apt-get install -y unzip git-core libicu-dev vim-tiny ssh \
 && rm -rf /var/lib/apt/lists/* /var/cache/apk/*

# Apache configuration
RUN a2enmod rewrite \
 && a2enmod ssl \
 && a2dissite 000-default \
 && echo ServerName localhost >> /etc/apache2/apache2.conf

COPY vhost/* /etc/apache2/sites-available/
COPY php.ini /usr/local/etc/php/

RUN a2ensite symfony

# PECL / extension builds and install
RUN pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && docker-php-ext-install bcmath intl sockets opcache pdo_mysql

# Enable remote debugging with xdebug
RUN echo 'xdebug.remote_enable=on' >> /usr/local/etc/php/php.ini
# && echo 'xdebug.remote_connect_back=on' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
# && echo 'xdebug.remote_autostart=on' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install APCU
RUN pecl install apcu-5.1.17 \
 && docker-php-ext-enable apcu

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require hirak/prestissimo