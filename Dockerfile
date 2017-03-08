FROM ilovintit/php5.6-apache
MAINTAINER lionetech <lion@lionetech.com>

#配置cron
#RUN echo "* * * * * /usr/bin/php /app/artisan schedule:run" > /var/spool/cron/crontabs/root && chmod 0600 /var/spool/cron/crontabs/root

#配置supervisor

RUN { \
    echo "[supervisord]";\
    echo "nodaemon=true";\
    echo "[program:laravel-worker]";\
    echo "process_name=%(program_name)s_%(process_num)02d";\
    echo "command=php /app/artisan queue:work --daemon";\
    echo "autostart=true";\
    echo "autorestart=true";\
    echo "user=www-data";\
    echo "numprocs=1";\
    echo "redirect_stderr=true";\
    echo "stdout_logfile=/app/storage/logs/worker.log";\
    echo "[program:apache2]"; \
    echo "command=/bin/bash -c \"source /etc/apache2/envvars && exec /usr/sbin/apache2 -DFOREGROUND\"";\
} > /etc/supervisor/conf.d/supervisord.conf

#部署代码
RUN mkdir -p /app
WORKDIR /app
COPY ./composer.json /app/
COPY ./composer.lock /app/
RUN composer install --prefer-dist  --no-autoloader --no-scripts
COPY . /app
RUN composer install --prefer-dist \
	&& chown -R www-data:www-data /app

#配置虚拟主机

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY ./ssl /etc/apache2/ssl
COPY ./vhost.conf /etc/apache2/sites-enabled/
#创建启动命令

RUN { \
    echo "#!/bin/sh";\
    echo "/usr/bin/supervisord";\
} > /start.sh && chmod +x /start.sh

EXPOSE 443

CMD ["/usr/bin/supervisord"]