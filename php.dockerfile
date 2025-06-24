FROM php:8.4-fpm-alpine
# Install dependencies

USER root


RUN docker-php-ext-install pdo pdo_mysql mysqli


RUN adduser -g  laravel -s /bin/bash -D laravel

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN sed -i 's/user = www-data/user = laravel/g' /usr/local/etc/php-fpm.d/www.conf
RUN sed -i 's/group = www-data/group = laravel/g' /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/public
RUN mkdir /var/www/html/public/storage

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

RUN

# execute the entrypoint script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# CMD ["/usr/local/bin/entrypoint.sh"]
# Copy .htaccess

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
