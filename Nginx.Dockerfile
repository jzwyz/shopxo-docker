FROM nginx

ADD ./etc/nginx/default.conf /etc/nginx/conf.d/
ADD ./shopxo /var/www/html/
ADD ./etc/nginx/default.template.conf /etc/nginx/conf.d/default.template

RUN chmod -R 777 /var/www/html/

ENV NGINX_HOST=localhost

EXPOSE 80 443
