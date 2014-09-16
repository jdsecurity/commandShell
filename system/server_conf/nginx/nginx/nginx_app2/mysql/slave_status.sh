#!/usr/bin/env bash

repeat_alert_interval=15 # minutes
lock_file=/tmp/slave_alert.lck
active=yes

## Check if alert is already sent ## 

function check_alert_lock () {
    if [ -f $lock_file ] ; then
        current_file=`find $lock_file -cmin -$repeat_alert_interval`
        if [ -n "$current_file" ] ; then
            # echo "Current lock file found"
            return 1
        else
            # echo "Expired lock file found"
            return 2 
        fi
    else
    return 0
    fi
}

## Find the location of the mysql.sock file ##

function check_for_socket () {
        if [ -z $socket ] ; then
                if [ -S /var/lib/mysql/mysql.sock ] ; then
                        socket=/var/lib/mysql/mysql.sock
                elif [ -S /tmp/mysql.sock ] ; then
                        socket=/tmp/mysql.sock
                else
                        ps_socket=`netstat -ln | egrep "mysql(d)?\.sock" | awk '{ print $9 }'`
                        if [ "$ps_socket" ] ; then
                        socket=$ps_socket
                        fi
                fi
        fi
        if [ -S "$socket" ] ; then
                echo UP > /dev/null
        else
                echo "No valid socket file "$socket" found!"
                echo "mysqld is not running or it is installed in a custom location"
                echo "Please set the $socket variable at the top of this script."
                exit 1
        fi
}


check_for_socket

Slave_IO_Running=`mysql -Bse "show slave status\G" | grep Slave_IO_Running | awk '{ print $2 }'`
Slave_SQL_Running=`mysql -Bse "show slave status\G" | grep Slave_SQL_Running | awk '{ print $2 }'`
Last_error=`mysql -Bse "show slave status\G" | grep Last_error | awk -F \: '{ print $2 }'`


if [ -z $Slave_IO_Running -o -z $Slave_SQL_Running ] ; then
        echo "Replication is not configured or you do not have the required access to MySQL"
        exit
fi

if [ $Slave_IO_Running == 'Yes' ] && [ $Slave_SQL_Running == 'Yes' ] ; then 
    if [ -f $lock_file ] ; then
        rm $lock_file
        echo "Replication slave is running"
        echo "Removed Alert Lock"
    fi
    exit 0
elif [ $Slave_SQL_Running == 'No' ] ; then
    if [ $active == 'yes' ] ; then
        check_alert_lock
        if [ $? = 1 ] ; then
            ## Current Lock ##
            echo "up" > /dev/null
        else
            ## Stale/No Lock ##
             touch $lock_file
            echo "SQL thread not running on server `hostname -s`!"
            echo "Last Error:" $Last_error
        fi
    fi
    exit 1
elif [ $Slave_IO_Running == 'No' ] ; then
        if [ $active == 'yes' ] ; then
                check_alert_lock
                if [ $? = 1 ] ; then
                        ## Current Lock ##
            echo "up" > /dev/null
                else
                        ## Stale/No Lock ##
                        touch $lock_file
                        echo "LOG IO thread not running on server `hostname -s`!"
                        echo "Last Error:" $Last_error
                fi
    fi
    exit 1
else 
        if [ $active == 'yes' ] ; then
                check_alert_lock
                if [ $? = 1 ] ; then
                        ## Current Lock ##
            echo "up" > /dev/null
                else
                        ## Stale/No Lock ##
                        touch $lock_file
            echo "Unexpected Error!"
            echo "Check Your permissions!"
                fi
        fi
    exit 2
fi
