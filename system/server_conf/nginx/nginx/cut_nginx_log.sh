#!/bin/bash
# This script is used cut the log of nginx

logpath='/var/slog/nginx'
targetpath=$logpath$(date -d +%Y)/$(date -d +%m)/$(date -d +%d)

mkdir -p $targetpath
mv $logpath'accesss.log' $targetpath
kill -USER1 `cat /web/nginx/nginx.pid`
