!#/bin/bash
# Install Apache+Nginx

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