#!/bin/bash
#15 3 * * * /usr/local/sbin/backup.sh
#Backup directory
BAK_DIR=/data/db_backup

TAR="/bin/tar"
TAR_FLAG="czvf"
###################Backup############################
if [ ! -d $BAK_DIR ];then
          mkdir -p $BAK_DIR
fi
#/etc/init.d/mysql stop
#sleep 10
COMM="$TAR $TAR_FLAG $BAK_DIR/linuxtone_bbs-`date +%Y%m%d`.tar.gz linuxtone_bbs/"
cd /data/mysql/data
eval $COMM
#/etc/init.d/mysql start
find $BAK_DIR -name "linuxtone_bbs-*.tar.gz" -mtime +7 |xargs rm -rf
