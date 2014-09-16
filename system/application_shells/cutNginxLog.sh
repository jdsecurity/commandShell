#!/bin/bash
# This shell executed at 00:00 everyday.

nginxRootPath='/var/slog/nginx/'
nginxLogsPath=${nginxRootPath}'logs/'

year=`date '+%Y'`
month=`date '+%m'`
day=`date '+%d'`
filePrefix=`date '+%s'`

logBakPath=${nginxRootPath}${year}'/'${month}'/'${day}'/'
if [ ! -d ${logBakPath} ]; then
    mkdir -p ${logBakPath}
fi

for logFile in `ls ${nginxLogsPath}`;
do
    logFileFull=${nginxLogsPath}${logFile}
    if [ -f ${logFileFull} ]; then
        mv ${logFileFull} ${logBakPath}${logFile}
    fi
done

kill -USR1 `cat ${nginxRootPath}'nginx.pid'`
