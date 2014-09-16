#!/bin/bash
# execute sql files.

tables1=(chongwen cp200609 cy200609 daxing dongcheng dt200609 fangshan ft hd huairou mentougou)
tables2=(miyun pinggu shijingshan shyi tongzhou xicheng xuanwu yanqing)

for table1 in ${tables1[@]}
do
echo ${table1}

echo "INSERT into allcodes(a, b, c, d) SELECT a, b, c, d FROM ${table1}" > /tmp/result.sql;
#`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' areacodes < /tmp/result.sql`
done

for table2 in ${tables2[@]}
do
echo ${table2}

echo "INSERT into allcodes(a, b, c, d, e, f, g, h) SELECT a, b, c, 50, e, g, i, k  FROM ${table2}" > /tmp/result.sql;
#`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' areacodes < /tmp/result.sql`
done

echo "UPDATE allcodes SET area='cw' WHERE b='崇文';
UPDATE allcodes SET area='dc' WHERE b='东城';
UPDATE allcodes SET area='ft' WHERE b='丰台';
UPDATE allcodes SET area='dt' WHERE b='地铁';
UPDATE allcodes SET area='dx' WHERE b='大兴';
UPDATE allcodes SET area='xw' WHERE b='宣武';
UPDATE allcodes SET area='my' WHERE b='密云';
UPDATE allcodes SET area='pg' WHERE b='平谷';
UPDATE allcodes SET area='yq' WHERE b='延庆';
UPDATE allcodes SET area='hr' WHERE b='怀柔';
UPDATE allcodes SET area='fs' WHERE b='房山';
UPDATE allcodes SET area='cp' WHERE b='昌平';
UPDATE allcodes SET area='cy' WHERE b='朝阳';
UPDATE allcodes SET area='hd' WHERE b='海淀';
UPDATE allcodes SET area='sjs' WHERE b='石景山';
UPDATE allcodes SET area='xc' WHERE b='西城';
UPDATE allcodes SET area='tz' WHERE b='通州';
UPDATE allcodes SET area='mtg' WHERE b='门头沟';
UPDATE allcodes SET area='sy' WHERE b='顺义';
UPDATE allcodes SET brand='1' WHERE c='北京全球通用户';
UPDATE allcodes SET brand='2' WHERE c='北京动感地带用户';
UPDATE allcodes SET brand='3' WHERE c='北京神州行大众卡用户';
UPDATE allcodes SET brand='4' WHERE c='北京神州行用户';
UPDATE allcodes SET sstatus='1' WHERE e='是';
UPDATE allcodes SET isvip='1' WHERE f='是';
"> /tmp/result.sql

#`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' --default-character-set=utf8 areacodes < /tmp/result.sql`

echo "UPDATE allcodes as a, fcode as f SET a.isused=1 WHERE a.a=f.ncode;
UPDATE allcodes SET sstatus=99 WHERE sstatus=1;
UPDATE fcode as f, allcodes as a SET f.brand = a.brand, f.area = a.area,f.consume = a.d, f.isvip = a.isvip WHERE f.ncode = a.a;
UPDATE fcode as f, allcodes as a SET f.sstatus=a.sstatus WHERE a.a=f.ncode AND f.sstatus=0;
INSERT INTO fcode(pre, ncode, c_type, brand, consume, isvip, area) SELECT LEFT(a, 3), a, 57, brand, d, isvip, area FROM allcodes WHERE isused=0;
" > /tmp/result.sql;
`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' --default-character-set=utf8 codes < /tmp/result.sql`
