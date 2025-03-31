FROM php:8.3-fpm

RUN apt-get update
RUN apt-get install cron -y
RUN apt-get install git -y
RUN apt-get install mc -y
RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN (echo "PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin";  \
    echo "SHELL=/bin/bash";   \
    echo "* * * * * /usr/local/bin/php /app/bin/console app:start-tracking >> /tmp/cron_php.log 2>&1";  \
    ) | crontab -

WORKDIR /app

ENTRYPOINT ["/bin/sh", "-c", "service cron start && tail -f /dev/null"]

CMD php-fpm
