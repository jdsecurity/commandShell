#!/bin/bash

cd /tmp/codearea/
t_midcode=zmid_code_area
t_area=sms_code_area
t_section=sms_code_section
for sqlfile in `ls `
do
	echo /tmp/codearea/$sqlfile 
	echo "LOAD DATA INFILE '/tmp/codearea/$sqlfile' INTO TABLE $t_midcode character set utf8;" > /tmp/result.sql;
	`/usr/local/webserver/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' mobile < /tmp/result.sql`
done

echo "DELETE FROM $t_midcode WHERE code_sec = 0; INSERT INTO $t_area(parentid, area) SELECT 0, province FROM $t_midcode GROUP BY province; INSERT INTO $t_area(parentid, area, province) SELECT a.id, c.city, c.province FROM $t_area as a, $t_midcode as c WHERE a.area = c.province GROUP BY c.province, c.city; INSERT INTO $t_section(areaid, code_sec, zone) SELECT a.id, c.code_sec, c.zone FROM $t_midcode as c, $t_area as a WHERE c.province = a.province AND c.city = a.area;" > /tmp/result.sql;
`/usr/local/webserver/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' mobile < /tmp/result.sql`
