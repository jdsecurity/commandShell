#!/bin/bash
# This shell executed at 00:00 everyday.

logs_path="/var/log/nginx/"

mkdir -p ${logs_path}$(date -d "yesterday"+"%Y")/$(date -d "yesterday"+"%m")/
mv ${logs_path}access.log ${logs_path}$(date -d "yesterday"+"%Y")/$(date -d "yesterday"+"%m")/access_$(date -d "yesterday"+"%Y%m%d").log
kill -USR1 `cat /web/nginx/logs/nginx.pid


#00 00 * * * /bin/bash /root/bin/nginx_log.sh`
