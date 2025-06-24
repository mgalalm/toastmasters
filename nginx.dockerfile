FROM nginx:stable-alpine

RUN mkdir -p /var/www/html/public

ADD conf/nginx.conf /etc/nginx/conf.d/default.conf

RUN sed -i 's/user www-data/user laravel;/g' /etc/nginx/nginx.conf

RUN adduser -g laravel -s /bin/bash -D laravel

# Add user for laravel application




