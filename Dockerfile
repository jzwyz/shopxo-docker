FROM nanoninja/php-fpm:7.4.4

ADD ./shopxo /var/www/html/
ADD ./etc/php/php.ini /usr/local/etc/php/conf.d/

RUN chmod -R 777 /var/www/html/

ENV PHP_VERSION=latest


