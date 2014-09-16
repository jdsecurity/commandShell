#!/bin/bash
# execute sql files.
#echo "$#";
#echo "$@";
#`mkdir /tmp/test`
#echo 'oooooooooooooo';
echo "TRUNCATE TABLE mcode;LOAD DATA INFILE '$1' INTO TABLE mcode;UPDATE mcode SET codeext=code WHERE code>18999999999; UPDATE mcode SET code=LEFT(codeext, 11) WHERE codeext != 0;TRUNCATE TABLE code;INSERT INTO code(code) SELECT code FROM mcode GROUP BY code; UPDATE code as c, fcode as f SET c.c_type = $2 WHERE c.code=f.ncode;UPDATE code SET pre=LEFT(code,3); INSERT INTO fcode(ncode,c_type,pre) SELECT code,$2,pre FROM code WHERE c_type!=$2 AND ((code>13000000000 AND code<13999999999) OR (code>15000000000 AND code<15399999999) OR (code>15500000000 AND code<15999999999) OR (code>18000000000 AND code<18099999999) OR (code>18500000000 AND code<18999999999));" > /tmp/codes/load.sql

#echo "TRUNCATE TABLE mcode;LOAD DATA INFILE '$1' INTO TABLE mcode;UPDATE mcode SET codeext=code WHERE code>18999999999; UPDATE mcode SET code=LEFT(codeext, 11) WHERE codeext != 0;TRUNCATE TABLE code;INSERT INTO code(code) SELECT code FROM mcode GROUP BY code;UPDATE code as c, fcode as f SET c.c_type = f.c_type WHERE c.code=f.ncode;UPDATE code SET pre=LEFT(code,3);" > /tmp/codes/loadbak.sql

`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' codes < /tmp/codes/load.sql`

