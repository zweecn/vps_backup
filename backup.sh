#!/bin/bash

mysql_passwd=`cat passwd`

cd /root/vps_backup/

if [ ! -d /var/www/challenges ]; then
    mkdir -p /var/www/challenges/
fi

if [ ! -d wp_content ]; then
    mkdir wp_content
fi
rm -rf ./wp_content/*
cp -rf /home/wwwroot/favorbook.com/wp-content/* ./wp_content/
rm -rf /root/vps_backup/wp_content/cache

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

echo backup /etc/sysconfig/iptables
cp /etc/sysconfig/iptables /root/vps_backup/l2tp/
echo backup /etc/ipsec.d/ipsec.conf  /etc/ipsec.d/ipsec.secrets
cp /etc/ipsec.d/ipsec.* /root/vps_backup/l2tp/
echo backup /etc/xl2tpd/l2tp-secrets  /etc/xl2tpd/xl2tpd.conf
cp /etc/xl2tpd/* /root/vps_backup/l2tp/

git add .
git commit -m 'auto backup'
git pull
git push origin master

