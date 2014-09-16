#!/bin/bash

WEB_VIP=202.96.155.142
. /etc/rc.d/init.d/functions

case "$1" in
start)
        ifconfig lo:0 $WEB_VIP netmask 255.255.255.255 broadcast $WEB_VIP up
        /sbin/route add -host $WEB_VIP dev lo:0
        echo "1" >/proc/sys/net/ipv4/conf/lo/arp_ignore
        echo "2" >/proc/sys/net/ipv4/conf/lo/arp_announce
        echo "1" >/proc/sys/net/ipv4/conf/all/arp_ignore
        echo "2" >/proc/sys/net/ipv4/conf/all/arp_announce
        sysctl -p >/dev/null 2>&1
        echo "RealServer Start OK"
        ;;
stop)
        ifconfig lo:0 down
        route del $WEB_VIP >/dev/null 2>&1
        echo "0" >/proc/sys/net/ipv4/conf/lo/arp_ignore
        echo "0" >/proc/sys/net/ipv4/conf/lo/arp_announce
        echo "0" >/proc/sys/net/ipv4/conf/all/arp_ignore
        echo "0" >/proc/sys/net/ipv4/conf/all/arp_announce
        echo "RealServer Stoped"
        ;;
 status)
         # Status of LVS-DR real server.
         islothere=`/sbin/ifconfig lo:0 | grep $WEB_VIP`
         isrothere=`netstat -rn | grep "lo:0" | grep $web_VIP`
         if [ ! "$islothere" -o ! "isrothere" ];then
             # Either the route or the lo:0 device
             # not found.
             echo "LVS-DR real server Stopped."
         else
             echo "LVS-DR Running."
         fi
         ;;
*)
         # Invalid entry.
         echo "$0: Usage: $0 {start|status|stop}"
         exit 1
         ;;
esac
exit 0
`