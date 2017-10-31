#!/bin/sh

echo $1
chmod -R 777 *
rsync -av ./* /webpages/$1
