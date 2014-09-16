#!/bin/bash
# execute sql files.
#echo "$#";
#echo "$@";

`rm -rf /tmp/codes`
`mkdir /tmp/codes`
`chmod 777 /tmp/codes`

codetype=$1
codepre=$2
codebrand=$3
codearea=$4

codenum=$5
codenums=$6
codetimes=$7
codeconsume=$8
codeisvip=$9
shift
suffix=$9

codesfile='/tmp/codes/codesfile.txt'
rcodefile='/tmp/codes/rcode.sql'
coderesult=r${codenum}_${codetype}_${codepre}_${codebrand}_${codearea}_${codenums};
`rm -f /tmp/codes/sqlfile.txt`
`rm -rf /tmp/codes/${coderesult}`

if [ "${codetype}" != 'no' ];    then 
    rtype=" AND c_type = ${codetype} "
fi

if [ "${codepre}" != 'no' ]; then 
    rpre=" AND pre = ${codepre} "
fi

if [ "${codebrand}" != 'no' ]; then
    rbrand=" AND brand = ${codebrand} "
fi

if [ "${codearea}" != 'no' ]; then
    rarea=" AND area = '${codearea}' "
fi

if [ "${codenums}" != 'no' ]; then 
    rnums=" LIMIT 0, ${codenums}"
    cnums=" LIMIT ${codenums}"
fi

if [ "${codetimes}" != 'no' ]; then
    if [ "${codetimes}" = 500 ]; then
 	rtimes=" AND times > 10 "
    else
    	rtimes=" AND times = ${codetimes} "
    fi
fi

if [ "${codeconsume}" != 'no' ]; then
    rconsume=" AND consume > ${codeconsume} "
fi

if [ "${codeisvip}" != 'no' ]; then
    risvip=" AND isvip = 1 "
fi

#echo "SELECT ncode FROM fcode WHERE sstatus != 99 ${rtype} ${rpre} ${rbrand} ${rarea} ${rtimes} ${rconsume} ${risvip} ${rnums} INTO OUTFILE '${codesfile}' lines terminated by '\r\n';" > ${rcodefile}

echo "SELECT ncode FROM fcode WHERE sstatus != 99 ${rtype} ${rpre} ${rbrand} ${rarea} ${rtimes} ${rconsume} ${risvip} ${rnums} INTO OUTFILE '${codesfile}' lines terminated by '\r\n'; UPDATE fcode SET times=times+1 WHERE sstatus != 99 ${rtype} ${rpre} ${rbrand} ${rarea} ${rtimes} ${rconsume} ${risvip} ${cnums}" > ${rcodefile}

`/web/mysql/bin/mysql -uroot -p'data@&)#*>CNroot' codes < /tmp/codes/rcode.sql`

if [ -f ${codesfile} ]; then
    `mkdir /tmp/codes/${coderesult}`
    `split -l ${codenum} ${codesfile} /tmp/codes/${coderesult}/`

    cd /tmp/codes/${coderesult}
    for txtfile in `ls `
    do
        `echo -e "13391668828\r\n" >> ${txtfile}`
        `echo -e "15811536467\r\n" >> ${txtfile}`
        mv ${txtfile} ${codenum}_${txtfile}.txt
    done

    #suffix=`date +%s`
    #`rm -f /var/htmlwww/code/data/rcode/${coderesult}.tgz`
    tar zcvf /var/htmlwww/code/data/rcode/${coderesult}_${suffix}.tgz /tmp/codes/${coderesult}
fi
