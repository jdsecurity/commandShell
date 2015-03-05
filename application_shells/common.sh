#!/bin/bash
# execute sql files.
#echo "$#";
#echo "$@";
#`mkdir /tmp/test`
#echo 'oooooooooooooo';
echo "TRUNCATE TABLE mcode;LOAD DATA INFILE '$1' INTO TABLE mcode;TRUNCATE TABLE code;INSERT INTO code(code) SELECT code FROM mcode GROUP BY code;UPDATE code as c, fcode as f SET c.c_type = $2 WHERE c.code=f.ncode;UPDATE code SET pre=LEFT(code,3); INSERT INTO fcode(ncode,c_type,pre) SELECT code,$2,pre FROM code WHERE c_type!=$2 AND ((code>13000000000 AND code<13999999999) OR (code>15000000000 AND code<15399999999) OR (code>15500000000 AND code<15999999999) OR (code>18000000000 AND code<18099999999) OR (code>18500000000 AND code<18999999999));UPDATE fcode as f, code as c SET f.c_type=$2 WHERE c.code=f.ncode AND f.c_type=1;UPDATE fcode SET mark=1 WHERE c_type=$2" > /tmp/codes/load.sql

`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' codes < /tmp/codes/load.sql`



cd /tmp/result/

for txtfile in `ls `
do
txtfile=/tmp/result/${txtfile}
echo ${txtfile}
echo "TRUNCATE TABLE result;LOAD DATA INFILE '${txtfile}' INTO TABLE result Fields Terminated By ',' Enclosed By '\"' Escaped By '\"'; UPDATE result SET sstatus=1 WHERE rstatus='DELIVRD'; TRUNCATE TABLE sresult; INSERT INTO sresult(code, sstatus) SELECT code, sstatus FROM result GROUP BY code ORDER BY sstatus DESC; UPDATE sresult SET sstatus=99 WHERE sstatus = 0; UPDATE fcode as f, sresult as r SET f.sstatus=r.sstatus WHERE r.sstatus=1 AND r.code=f.ncode; UPDATE fcode as f, sresult as r SET f.sstatus=r.sstatus WHERE r.sstatus=99 AND r.code=f.ncode AND f.sstatus!=1;" > /tmp/result.sql;
`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' codes < /tmp/result.sql`
done


cd /tmp/result/

for txtfile in `ls `
do
txtfile=/tmp/result/${txtfile}
echo ${txtfile}
echo "LOAD DATA INFILE '${txtfile}' INTO TABLE result Fields Terminated By ',' Enclosed By '\"' Escaped By '\"';" > /tmp/result.sql;
`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' bakdb < /tmp/result.sql`
done

echo "UPDATE result SET sstatus=1 WHERE rstatus='DELIVRD'; INSERT INTO sresult(code, sstatus, times) SELECT code, sstatus, count(*) as count FROM result GROUP BY code ORDER BY sstatus DESC; UPDATE sresult SET sstatus=99 WHERE sstatus = 0;" >/tmp/rresult.sql;
`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' bakdb < /tmp/rresult.sql`



cd /tmp/codes/codes
numn=0
i=1
for sqlfile in `ls `
do
echo ${numn}
if [ ${numn} -lt 180000 ]; then
	pre=159
elif [ ${numn} -lt 300000 ]; then
        pre=158
elif [ ${numn} -lt 640000 ]; then
        pre=139
elif [ ${numn} -lt 1250000 ]; then
        pre=138
elif [ ${numn} -lt 1500000 ]; then
        pre=137
elif [ ${numn} -lt 2120000 ]; then
        pre=136
elif [ ${numn} -lt 2760000 ]; then
        pre=135
elif [ ${numn} -lt 3900000 ]; then
        pre=134
fi
echo ${pre}
mv ${sqlfile} ${i}_${pre}.txt
numn=$[ ${numn}+20000 ]
i=$[ ${i}+1 ]
done


#echo "$#";
#echo "$@";
`mkdir /tmp/test`
echo 'oooooooooooooo';
#echo "TRUNCATE TABLE mcode;LOAD DATA INFILE '$1' INTO TABLE mcode;TRUNCATE TABLE code;INSERT INTO code(code) SELECT code FROM mcode GROUP BY code;UPDATE code as c, fcode as f SET c.c_type = $2 WHERE c.code=f.ncode;INSERT INTO fcode(ncode,c_type) SELECT code,$2 FROM code WHERE c_type!=$2;" > /home/wangcanliang/bin/load.sql

#`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' codes < /home/wangcanliang/bin/load.sql`


cd /home/wangcanliang/game

for sqlfile in `cat /tmp/prefixcode.txt`
do
echo "SELECT code FROM telephone WHERE prefix= ${sqlfile} INTO OUTFILE '/tmp/codes/${sqlfile}.txt'" > /tmp/codesql.sql
echo ${sqlfile}
`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' codes < /tmp/codesql.sql`

done


echo "TRUNCATE TABLE result;LOAD DATA INFILE '/tmp/mt_20101116_3842.txt' INTO TABLE resultbak2 Fields Terminated By ',' Enclosed By '\"' Escaped By '\"'; " > /tmp/result.sql;
`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' codes < /tmp/result.sql`


cd /home/wangcanliang/newcodes

for sqlfile in `ls `
do
echo ${sqlfile}
`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' --default-character-set=utf8 areacodes < ${sqlfile}`

done


for jsfile in `cat /root/jsfile.txt`
do
#echo /var/htmlwww/games/${jsfile}
sssfile=/var/htmlwww/games/${jsfile};
#echo ${sssfile}
pathtarget=`dirname ${sssfile}`
mkdir -p /root/jsfile/${pathtarget}
echo ${pathtarget}
cp ${sssfile} /root/jsfile/${pathtarget} -r
done

