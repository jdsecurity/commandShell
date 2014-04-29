#!/bin/sh
# MySQL backup

dbUser='root'
dbPassword='password'

backupPath='/var/bak/sql/'
formatDate=`date +%Y%m%d`

databases=(data1 data2)

for currentDb in ${databases[*]}
do
  `/opt/soft/mysql/bin/mysqldump -uroot -p'password' --default-character-set=utf8 --database ${currentDb} > ${BACKUP_DIR}$currentDb}-${formatDate}.sql`
  `rm -rf ${backupPath}$currentDb}-$(date +%Y%m%d -d '7 days ago').sql`
done
