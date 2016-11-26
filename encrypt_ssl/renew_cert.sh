#!/bin/bash

cd /root/encrypt_ssl
python acme_tiny.py --account-key account.key --csr domain.csr --acme-dir /var/www/challenges/ > signed.crt || exit
wget -O - https://letsencrypt.org/certs/lets-encrypt-x3-cross-signed.pem > intermediate.pem
cat signed.crt intermediate.pem > chained.pem

kill -HUP `cat /usr/local/nginx/logs/nginx.pid`
service nginx restart
# service nginx reload

