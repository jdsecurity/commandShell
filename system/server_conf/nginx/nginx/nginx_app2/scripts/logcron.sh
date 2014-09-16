#!/bin/bash
log_dir="/data/logs"
time=`date +%Y%m%d`  
/bin/mkdir -p  ${log_dir}/${date_dir} > /dev/null 2>&1
/bin/mv  ${log_dir}/access_count.linuxtone.org.log ${log_dir}/access_count.linuxtone.org.$time.log
kill -USR1 `cat  /var/run/nginx.pid`
