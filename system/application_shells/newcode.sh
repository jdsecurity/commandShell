#!/bin/bash
# execute sql files.
sqlpath=/var/htmlwww/zf001net/data/codes/input/
sqlfile=$sqlpath$1'.sql'

`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' mobile < $sqlfile`

