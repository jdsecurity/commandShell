#!/bin/bash

svnInfos=(bbs games ganwan ghome ghucenter gwflash gwmain gwmblog gwuser jzsg jzsgbbs miniblog pay svnupdate)
for svnInfo in ${svnInfos[*]}
do
    echo ${svnInfo}
    echo "svn switch --relocate http://117.79.238.169:8088/newsvn/${svnInfo} http://117.79.238.186:8088/newsvn/${svnInfo} /var/htmlwww/${svnInfo}"
    `svn switch --relocate http://117.79.238.169:8088/newsvn/${svnInfo} http://117.79.238.186:8088/newsvn/${svnInfo} /var/htmlwww/${svnInfo}`
done
