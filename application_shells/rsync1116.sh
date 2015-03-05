#!/bin/bash

webProducts=(bbs games jzsgbbs ganwan ghome ghucenter jzsg miniblog gwmain weihu webplat pay)
for webProduct in ${webProducts[*]}
do
	`rsync -zvRrtopg --delete daemon@192.168.1.186::web$webProduct /var/htmlwww/$webProduct >> /var/bak/186_bak3/web$webProduct.txt`
done
