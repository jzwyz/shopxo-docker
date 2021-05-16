FROM nginx

ADD ./etc/nginx/default.conf /etc/nginx/conf.d/
ADD ./shopxo /var/www/html/

RUN chmod -R 777 /var/www/html/

ENV NGINX_HOST=localhost

EXPOSE 80 443
