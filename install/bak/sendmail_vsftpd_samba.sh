!#/bin/bash
# Install sendemail, vsftpd, samba 

# Install sendmail
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

# Install vsftpd
tar jxvf /home/wangcanliang/source/vsftpd* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/vsftpd*/
./configure --prefix=/webnew/httpd \
--enable-dav \
--enable-so \
--enable-dav-fs
make
make install

tar jxvf /home/wangcanliang/source/pcre* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/pcre*
./configure --prefix=/webnew/pcre
make
make install

tar zxvf /home/wangcanliang/source/nginx-1* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/nginx*
./configure --prefix=/webnew/nginx --with-http_stub_status_module --with-pcre=/home/wangcanliang/spath/pcre-8*
make
make install

mkdir /web/nginx/conf/server
mkdir /var/slog/nginx
chown webuser.webuser /var/slog/nginx -R

#vi /web/nginx/conf/nginx.conf
#vi /web/nginx/conf/server/*.conf
#vi /web/nginx/conf/fcgi.conf

ulimit -SHn 56635
/web/nginx/sbin/nginx

kill -HUP `cat /web/nginx/nginx.pid`

# Install samba
wget http://ftp.samba.org/pub/samba/samba-4.0.0.tar.gz
tar zxvf /home/wangcanliang/source/samba* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/samba*/source3
#./autogen-sh
./configure --prefix=/webnew/samba 
make
make install

touch /etc/ld.so.conf.d/samba.conf
echo '/webnew/samba/lib' > /etc/ld.so.conf.d/samba.conf
ldconfig
