FROM php:8.4-fpm-alpine
# Install dependencies

USER root

RUN apk update && apk add --no-cache \
    nginx \
    bash \
    curl \
    supervisor

RUN rm /etc/nginx/http.d/default.conf

ADD conf/nginx.conf /etc/nginx/http.d/nginx.conf

COPY conf/supervisord.conf /etc/supervisord.conf

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN adduser -g  laravel -s /bin/bash -D laravel

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN sed -i 's/user = www-data/user = laravel/g' /usr/local/etc/php-fpm.d/www.conf
RUN sed -i 's/group = www-data/group = laravel/g' /usr/local/etc/php-fpm.d/www.conf
RUN sed -i 's/user nginx/user laravel/g' /etc/nginx/nginx.conf

RUN mkdir -p /var/www/html/public
RUN mkdir /var/www/html/public/storage

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

# execute the entrypoint script
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]


CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
