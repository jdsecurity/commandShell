#!/bin/bash
# This shell executed at 00:00 everyday.

logs_root=("/var/log/nginx/" )
year=`date '+%Y'`
month=`date '+%m'`
day=`date '+%d'`
fileprefix=`date '+%s'`

for logs_path in "${logs_root[@]}";
do
    logpath=${logs_path}${year}/${month}/${day}
    if [ ! -d ${logpath} ]; then
        mkdir -p ${logpath}
    fi

    for logfile in `ls ${logs_path}`
    do
        if [ -f ${logs_path}${logfile} ]; then
#            mv ${logs_path}${logfile} ${logpath}/${fileprefix}${logfile}
           mv ${logs_path}${logfile} ${logpath}/${logfile}
        fi
    done
#    webname=${logs_path:15:1}
#    kill -USR1 `cat /web/${webname}nginx/logs/nginx.pid`
    kill -USR1 `cat /usr/local/webserver/nginx/logs/nginx.pid`
done
