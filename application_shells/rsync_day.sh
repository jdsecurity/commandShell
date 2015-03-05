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
webProducts=(bbs games ghucenter gwmain products 18481com)
for webProduct in ${webProducts[*]}
do
echo "rsync -zvRrtopg --bwlimit=5000 --delete daemon@192.168.1.186::web$webProduct /var/bak/$bakPath/$webProduct"
        `rsync -zvRrtopg --bwlimit=5000 --delete --exclude-from=/root/bin/exclude.txt daemon@192.168.1.186::web$webProduct /var/bak/$bakPath/$webProduct >> /var/bak/$bakPath/web$webProduct.txt`
done

echo $bakPath > $bakPathFile

