FROM php:7.2-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        supervisor \
        nginx \
        libcurl4-gnutls-dev \
        libsqlite3-0 \
        curl && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo \
    curl \
    json

COPY ./docker/web/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/web/php/zz-disable-access-logs.conf /usr/local/etc/php-fpm.d/zz-disable-access-logs.conf
COPY ./docker/web/php.ini /usr/local/etc/php/php.ini
COPY ./docker/web/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/web/error_pages /etc/nginx/error_pages
COPY ./src /opt/src/
COPY ./bin /opt/bin/

EXPOSE 80
WORKDIR /opt
CMD ["/usr/bin/supervisord"]
