# IPTV omxplayer web controller

Установить lighttpd и php:
sudo apt-get install lighttpd
sudo apt-get install php7.3-fpm php7.3-mbstring php7.3-mysql php7.3-curl php7.3-gd php7.3-curl php7.3-zip php7.3-xml -y

Сконфигурировать lighttpd:
sudo lighttpd-enable-mod fastcgi
sudo lighttpd-enable-mod fastcgi-php

Обновить конфигурацию для PHP-CGI:
sudo nano /etc/lighttpd/conf-available/15-fastcgi-php.conf

Обновить содержимое:
# -*- depends: fastcgi -*-
# /usr/share/doc/lighttpd/fastcgi.txt.gz
# http://redmine.lighttpd.net/projects/lighttpd/wiki/Docs:ConfigurationOptions#mod_fastcgi-fastcgi

## Start an FastCGI server for php (needs the php5-cgi package)
fastcgi.server += ( ".php" =>
        ((
                "socket" => "/var/run/php/php7.3-fpm.sock",
                "broken-scriptfilename" => "enable"
        ))
)

Перезагрузить сервер:
sudo service lighttpd force-reload

Проверить работу, создав файл по пути sudo nano /var/www/html/index.php.
Добавить содержимое:
<?php phpinfo(); ?>

Получить адрес и перейти по нему в браузере (локальная сеть):
hostname -I

Перейти в директорию:
cd /var/www/html

Клонировать репозиторий:
sudo git clone https://github.com/mrbaco/IPTV-Raspberry-PI-web-client.git ./

Создать новый сервис:
sudo nano /lib/systemd/system/iptv_runner.service

Добавить содержимое:
[Unit]
Description=Script to show splash screen
After=multi-user.target
[Service]
Type=idle
ExecStart=/var/www/html/splash.sh
[Install]
WantedBy=multi-user.target

Присвоить права:
sudo chmod 644 /lib/systemd/system/iptv_runner.service

Обновить конфигурацию:
sudo systemctl daemon-reload

Добавить скрипт в автозагрузку:
sudo systemctl enable iptv_runner.service

Назначить права на запуск файлов:
sudo chmod 0755 /var/www/html/run_player.sh
sudo chmod u+x /var/www/html/splash.sh
