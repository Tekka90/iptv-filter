FROM php:8-apache-buster

RUN apt-get update && \
    apt-get install -y cron && \
    rm -rf /var/lib/apt/lists/*

COPY cron.input /etc/cron.d/iptv-cron
COPY *.php /var/www/html/
COPY iptv-tv.sh /var/www/html
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN chmod 0644 /etc/cron.d/iptv-cron && \
    crontab /etc/cron.d/iptv-cron && \
    mkdir /config && \
    chown -R www-data:www-data /var/www/html && \
    a2enmod rewrite

EXPOSE 80
