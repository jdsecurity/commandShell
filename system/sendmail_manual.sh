tar zxvf sendmail.8.14.tar.gz;
cd sendmail-8.14
vi devtools/Site/site.config.m4
	APPENDDEF(`confENVDEF', `-DSASL=2')
	APPENDDEF(`conf_sendmail_LIBS',`-lsasl2')

sh Build -c
sh Build install

mkdir /web/sendmail
cp -a cf /web/sendmail

cd cf/cf
cp generic-linux.mc sendmail.mc
make install-cf; cp sendmail.mv /etc/mail
cd /etc/mail
touch aliases access
echo "7038.cn">local-host-names
echo "mail.chinaitlab.com">>local-host-names
makemap hash access<access
mkdir /var/spool/mqueue
/usr/sbin/sendmail -bd -q1h


netstat -tnl | grep 25
useradd acan
passwd acan
echo "root:acan" >> /etc/mail/aliases
newaliases

telnet localhost 25

mail from: root@7038.cn
rcpt to:redhat@chinaitlab.com
data
hello.mail from smtp conmmand.
.
quit

tail /var/log/maillog
