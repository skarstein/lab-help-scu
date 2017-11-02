#!/bin/sh

echo $1
chmod -R 755 *
rsync -vra ./* /webpages/$1
cd /webpages/$1/php-cgi/
chmod 600 *.php
cd db_php
chmod 600 *.php
cd ../dev
chmod 600 *.php
cd ../partials
chmod 600 *.php
