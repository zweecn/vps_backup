#!/bin/bash

openssl genrsa 4096 > account.key
openssl genrsa 4096 > domain.key
openssl req -new -sha256 -key domain.key -subj "/" -reqexts SAN -config <(cat /etc/pki/tls/openssl.cnf <(printf "[SAN]\nsubjectAltName=DNS:favorbook.com,DNS:go.favorbook.com,DNS:mail.favorbook.com,DNS:www.favorbook.com,DNS:lucker.me,DNS:go.lucker.me,DNS:mail.lucker.me,DNS:www.lucker.me")) > domain.csr

if [ $? -ne 0 ]; then
	exit 1
fi

# wget https://raw.githubusercontent.com/diafygi/acme-tiny/master/acme_tiny.py --no-check-certificate
python acme_tiny.py --account-key ./account.key --csr ./domain.csr --acme-dir /var/www/challenges/ > ./signed.crt

if [ $? -ne 0 ]; then
	exit 1
fi

wget -O - https://letsencrypt.org/certs/lets-encrypt-x3-cross-signed.pem > intermediate.pem
cat signed.crt intermediate.pem > chained.pem

wget -O - https://letsencrypt.org/certs/isrgrootx1.pem > root.pem
cat intermediate.pem root.pem > full_chained.pem
