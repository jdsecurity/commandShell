#!/bin/sh
#mkdir /root/fuk

host=192.168.1.117
user=root
pass=acanacan

repos="$1"
rev="$2"
svntmp='/tmp/svntest'

validuser=('wangcan' 'miliang' 'zoubing' 'zhangzhigao')
svnlog=`/web/svn/bin/svnlook log -r ${rev} ${repos}`
#mkdir /root/${svnlog}

svnauthor=`/web/svn/bin/svnlook author -r ${rev} ${repos}`
#svnupdate=`/web/svn/bin/svn update -r ${rev} ${repos} ${svntmp}`
for name in ${validuser[@]}; do
#mkdir /root/${name}
if [ "${name}" = "${svnauthor}" ]; then

    `/web/svn/bin/svn update -r ${rev} ${repos} ${svntmp}` | awk '{
    	if [ $1 == "U" ]; then 
	    mkdir /root/test/$1
	fi
    }'

#    updatedata=`/web/svn/bin/svn update -r ${rev} ${repos} ${svntmp}`
#    `cat ${updatedata} > /root/svntest.txt`
#    `/web/svn/bin/svn update -r ${rev} ${repos} ${svntmp} > /root/svntest.txt`
#    for line in `/web/svn/bin/svn update -r ${rev} ${repos} ${svntmp}`; do
#        mkdir /root/test/${line}
#	echo "${line}" >> /root/test/svn.r
#    done
#mkdir /root/ok
fi
#mkdir /root/test/${name}
#mkdir /root/test/${svnauthor}
done
#mkdir /root/${svnauthor}
#echo ${repos}
#mkdir /root/fuck
#mkdir /root/${repos}/${rev}
#mailer.py commit "$repos" "$rev" /path/to/mailer.conf


HOST=192.168.1.125
USER=commonuser
PASS='common@&)#*>CN'

echo 'Starting to sftp...'

lftp -u ${USER},${PASS} sftp://${HOST}<<EOF
ls /root
#lcd /web/nginx/conf
#cd /var/bak/test
#for file in `ls /web/nginx/conf`
#do
#echo ${file}
#done
#mput *
bye
EOF

echo 'done'