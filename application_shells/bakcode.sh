#!/bin/bash
# execute sql files.

outpath='/var/htmlwww/zf001net_bak/data/codes/input/'
sqlfile=$outpath$1'.sql'
#echo $sqlfile
`/usr/local/webserver/mysql/bin/mysql -h192.168.1.188 -umobileback -p'mobileUserback' mobilebak < $sqlfile`

