#!/bin/bash

webProducts169=(18481com products)
for webProduct in ${webProducts169[*]}
do
        `rsync -zvRrtopg --delete daemon@192.168.1.169::web$webProduct /var/htmlwww/169web/$webProduct >> /var/htmlwww/169web/web$webProduct.txt`
done

webProducts186=(bbs games jzsgbbs ganwan ghome ghucenter jzsg miniblog)
for webProduct in ${webProducts186[*]}
do
        `rsync -zvRrtopg --delete daemon@192.168.1.186::web$webProduct /var/htmlwww/186web/$webProduct >> /var/htmlwww/186web/web$webProduct.txt`
done
