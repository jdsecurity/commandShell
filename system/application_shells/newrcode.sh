#!/bin/bash
# execute sql files.

outpath='/var/htmlwww/newzf001/data/codes/input/'
sqlfile=$outpath$1'.sql'
`/web/mysql/bin/mysql -h192.168.1.122 -umobileuser -p'mobileUser&)#*' mobile < $sqlfile`
