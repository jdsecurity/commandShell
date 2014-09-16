#!/bin/bash
# execute sql files.

codespath='/var/htmlwww/86web/codes/data/codes/'
outpath=$codespath'output/'
midpath=$outpath$1'/'
routpath=$codespath'routput/'

sqlfile=$outpath$1'.sql'
codesfile=$outpath$1'.txt'
codenum=$2

`/webnew/mysql/bin/mysql -uroot -p'local@!^(@data' codes < $sqlfile`

if [ -f $codesfile ]; then
    `rm -rf $midpath`
    `mkdir $midpath`

    `split -l $codenum $codesfile $midpath`

    cd $midpath
    for txtfile in `ls `
    do
#        `echo -e "13391668828\r" >> $txtfile`
#        `echo -e "15811536467" >> $txtfile`
	numprefix=`cat $txtfile | wc -l`
        mv $txtfile $numprefix'_'$txtfile.txt
    done

    cd $outpath
    tar zcvf $routpath$1'.tgz' $1
fi
