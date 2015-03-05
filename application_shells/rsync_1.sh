#!/bin/bash

bakPathFile=/var/bak/bakPath.txt
lastBakInfo=`cat $bakPathFile`
#echo $lastBakInfo
lastMark=${lastBakInfo:7:9}
#echo $lastMark
if [ $lastMark == 1 ]; then
	currentMark='2'
elif [ $lastMark == 2 ]; then
	currentMark='3'
elif [ $lastMark == 3 ]; then
	currentMark='1'
fi
bakPath='186_bak'$currentMark
#echo $bakPath
webProducts=(bbs games jzsgbbs ganwan ghome ghucenter jzsg miniblog)
for webProduct in ${webProducts[*]}
do
	`rsync -zvRrtopg --delete daemon@192.168.1.186::web$webProduct /var/bak/$bakPath/$webProduct >> /var/bak/$bakPath/web$webProduct.txt`
done

echo $bakPath > $bakPathFile 
