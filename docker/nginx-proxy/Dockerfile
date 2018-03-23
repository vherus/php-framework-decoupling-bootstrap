FROM nginx:1

COPY ./docker/nginx-proxy/certs/selfsign.cert /etc/nginx/ssl/selfsign.crt
COPY ./docker/nginx-proxy/certs/selfsign.key /etc/nginx/ssl/selfsign.key
COPY ./docker/nginx-proxy/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx-proxy/error_pages /etc/nginx/error_pages
