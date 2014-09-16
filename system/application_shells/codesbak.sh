#!/bin/bash

# Backup the web codes
DATE=`date +%Y-%m-%d`

tar zcvf /var/bak/games/games${DATE}.tgz --exclude=/var/htmlwww/games/20*/* --exclude=/var/htmlwww/games/{zshe,dszo,tiyu,yiai,qipl,veji,atbj,vtrf,cl,maox,yl,assets,pclist,speciallist,ertong,gaox,zz,zhuanji,shr,qipai,zhongw}/* --exclude=/var/htmlwww/games/special/{ztzshe,ztyiai,zttiyu,ztnvvg,ztmcjx,ztjydw,ztdszo,ztcelm,ztajag,ztetyl,ztyyyl,ztgxyl}/* --exclude=/var/htmlwww/games/search/data/* --exclude=/var/htmlwww/games/client/data/* --exclude=/var/htmlwww/games/data/cache/swf/* --exclude=/var/htmlwww/games/update/* /var/htmlwww/games/

tar zcvf /var/bak/ghome/ghome${DATE}.tgz --exclude=/var/htmlwww/ghome/attachment/* /var/htmlwww/ghome/

tar zcvf /var/bak/update/update${DATE}.tgz /var/htmlwww/updates/

/web/mysql/bin/mysqldump -h192.168.1.122 -ugamesduser -p'games&)#*>CNuser' --default-character-set=utf8 games >/var/bak/sql/games${DATE}.sql
