#!/bin/bash
# execute sql files.

codespath='/var/htmlwww/codes/data/codes/'
outpath=$codespath'output/'
routpath=${codespath}'routpput/'

for txtfile in `ls ${outpath}`
do
    baseFile=${txtfile%.txt}
    midpath=${outpath}${baseFile}
    echo ${baseFile}
echo ${txtfile}
echo ${midpath}
done

