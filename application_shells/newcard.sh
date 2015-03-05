#!/bin/bash

cardPath='/tmp/newcard/'
tmpsqlfile='/tmp/sqlfile.sql'
newcard='game_mstatic_newcard'
mysqlbin='/usr/local/mysql/bin/mysql'
sqlparam=" -uroot -p'data@!**@MAINweb' mac "

cd ${cardPath}
for codeFile in `ls `
do
        sqlfile=${cardPath}${codeFile}
echo $sqlfile
echo /usr/local/mysql/bin/mysql $sqlparam 
        echo "LOAD DATA INFILE '$sqlfile' INTO TABLE $newcard character set utf8;" > ${tmpsqlfile}
        `/usr/local/mysql/bin/mysql  -uroot -p'data@!**@MAINweb' mac < ${tmpsqlfile}`
done
