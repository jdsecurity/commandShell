#!/bin/bash

codeareapath='/tmp/codearea/'
t_midcode='zmid_code_area'
t_area='sms_code_area'
t_section='sms_code_section'
tmpsqlfile='/tmp/sqlfile.sql'
mysqlbin='/usr/local/mysql/bin/mysql'
sqlparam=" -uroot -p'data@&)#*>CNroot' mobile "

cd ${codeareapath}
for areafile in `ls `
do
        sqlfile=${codeareapath}${areafile}
        echo "LOAD DATA INFILE '$sqlfile' INTO TABLE $t_midcode character set utf8;" > ${tmpsqlfile}
        `/usr/local/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' mobile < ${tmpsqlfile}`
done

echo "DELETE FROM $t_midcode WHERE code_sec = 0; INSERT INTO $t_area(parentid, area) SELECT 0, province FROM $t_midcode GROUP BY province; INSERT INTO $t_area(parentid, area, province) SELECT a.id, c.city, c.province FROM $t_area as a, $t_midcode as c WHERE a.area = c.province GROUP BY c.province, c.city; INSERT INTO $t_section(areaid, code_sec, zone) SELECT a.id, c.code_sec, c.zone FROM $t_midcode as c, $t_area as a WHERE c.province = a.province AND c.city = a.area;" > ${tmpsqlfile};
`/usr/local/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' mobile  < ${tmpsqlfile}`

