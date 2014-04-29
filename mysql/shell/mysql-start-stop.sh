#!/bin/bash
# This shell executed at 00:00 everyday.

#ps -eo user,pid,%cpu,%mem,vsz,rsz,comm --sort -vsz | egrep 'mysql|COMMAND'
#/opt/soft/mysql/bin/mysqladmin -uroot -p'data@&)#*>CNroot' -S /tmp/mysql.sock  shutdown
#/opt/soft/mysql/bin/mysqld_safe --defaults-file=/opt/soft/mysql/etc/my.ini &


mysql_port=3306
mysql_username='admin'
mysql_password='admin'

start_mysql() {
	printf "Starting MySQL...\n"
	`/bin/sh /opt/soft/mysql/bin/mysqld_safe --defaults-file=/opt/soft/mysql/etc/my.ini 2 > $1 > /dev/null &`
}

stop_mysql() {
	printf "Stoping MySQL...\n"
	`/opt/soft/mysql/bin/mysqladmin -u${mysql_username} -p'${mysql_password}' -S /tmp/mysql.sock shutdown`
}

restart_mysql() {
	printf "Restarting MySQL...\n"
	stop_mysql
	sleep 5
	start_mysql
}

kill_mysql()
{
	kill -9 $(ps -ef | grep 'bin/mysqld_safe' | grep ${mysql_port} | awk '{printf $2}')
	kill -9 $(ps -ef | grep 'kibexec/mysqld' | grep ${mysql_port} | awk '{printf $2}')
}

if [ "$1" = "start" ]; then
	start_mysql
elif [ "$1" = "stop" ]; then
	stop_mysql
elif [ "$1" = "restart" ]; then
	restart_mysql
elif [ "$1" = "kill" ]; then
	kill_mysql
else
	printf "usage: /root/bin/mysql {start|stop|restart|kill}\n"
fi
