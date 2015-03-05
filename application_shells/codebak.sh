#!/bin/bash
# execute sql files.

codespath='/var/htmlwww/codes/'
outpath=$codespath'output/'
routpath=${codespath}'routput/'
midpath=${codespath}'midpath/'

for txtfile in `ls ${outpath}`
do
    baseFile=${txtfile%.txt}
    submidpath=${midpath}${baseFile}'/'
    `rm -rf ${submidpath}`
    `mkdir ${submidpath}`
    `split -l 100000 ${outpath}${txtfile} ${submidpath}`
    for subfile in `ls ${submidpath}`
    do
	echo ${subfile}
        numprefix=`cat ${submidpath}${subfile} | wc -l`
        mv ${submidpath}${subfile} ${submidpath}${numprefix}'_'${subfile}.txt
    done
    allnumprefix=`cat ${outpath}${txtfile} | wc -l`
    cd ${midpath}
    tar zcvf ${routpath}${baseFile}_${allnumprefix}.tgz ${baseFile}
done
