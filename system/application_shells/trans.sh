#!/bin/sh
#MySQL User Information

USERNAME=transuser
FILE_PREFIX=MySQL
BACKUP_DIR=/var/bak/85sql/

databases=(mobile) # mobile gamesext mclient mobilegame games cs_mobile
cd ${BACKUP_DIR}
for db in ${databases[*]}
do
echo "/usr/local/webserver/mysql/bin/mysqldump -h60.28.206.83 -u${USERNAME} -p'trans@user' --default-character-set=utf8 --database $db > ${BACKUP_DIR}$db.sql"
echo "/usr/local/webserver/mysql/bin/mysql -uroot -p'slave@staticWEB@!*%' --default-character-set=utf8 --database $db < ${BACKUP_DIR}$db.sql"
    /usr/local/webserver/mysql/bin/mysqldump -h60.28.206.83 -u${USERNAME} -p'trans@user' --default-character-set=utf8 --database $db > ${BACKUP_DIR}$db.sql
    /usr/local/webserver/mysql/bin/mysql -uroot -p'slave@staticWEB@!*%' --default-character-set=utf8 --database $db < ${BACKUP_DIR}$db.sql
done 
