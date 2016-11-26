#!/bin/bash

mysql_passwd=`cat passwd`

cd /root/vps_backup/

if [ ! -d /var/www/challenges ]; then
    mkdir -p /var/www/challenges/
fi

if [ ! -d wp_themes ]; then
    mkdir wp_themes
fi
rm -rf ./wp_themes/*
cp -rf /home/wwwroot/favorbook.com/wp-content/themes/* ./wp_themes/

if [ ! -d nginx_vhost ]; then
    mkdir nginx_vhost
fi
rm -rf ./nginx_vhost/*
cp -rf /usr/local/nginx/conf/vhost/* ./nginx_vhost/

if [ ! -d encrypt_ssl ]; then
    mkdir encrypt_ssl
fi
rm -rf ./encrypt_ssl/*
cp /root/encrypt_ssl/* ./encrypt_ssl/

if [ ! -d ./wp_sql ]; then
    mkdir wp_sql
fi
mysqldump -uroot -p${mysql_passwd} wp_blog > ./wp_sql/wp_blog.sql
if [ $? -ne 0 ]; then
    echo backup mysql failed!
fi

git add .
git commit -m 'auto backup'
git pull
git push origin master

