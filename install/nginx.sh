!#/bin/bash
# Install Nginx

cd /opt/sourcepackage
wget http://nginx.org/download/nginx-1.8.0.tar.gz

tar zxvf /opt/sourcepackage/nginx-1.* -C /opt/source
cd /opt/source/nginx-1.*
./configure \
--user=daemon \
--group=daemon \
--prefix=/opt/soft/nginx \
--with-http_stub_status_module \
--with-http_ssl_module \
--with-pcre=/opt/source/pcre-8.36 \
--with-http_realip_module \
--with-http_image_filter_module
make ; make install


mkdir /web/nginx/conf/server
mkdir /var/slog/nginx
chown webuser.webuser /var/slog/nginx -R

#vi /web/nginx/conf/nginx.conf
#vi /web/nginx/conf/server/*.conf
#vi /web/nginx/conf/fcgi.conf

ulimit -SHn 56635
/web/nginx/sbin/nginx

kill -HUP `cat /web/nginx/nginx.pid`


yum install kernel-devel -y
yum -y install ipvsadm
lsmod | grep ip_vs
ipvsadm
ln -s /usr/src/kernels/2.6.18-308.16.1.el5-x86_64/ /usr/src/linux
rm -rf /webnew/keepalived/
rm -rf /home/wangcanliang/spath/keepalived-1.2.7/
tar zxvf /home/wangcanliang/source/keepalived-1* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/keepalived-1*
./configure --prefix=/webnew/keepalived  --mandir=/usr/local/share/man/ --with-kernel-dir=/usr/src/linux/
make
make install


tar zxvf /home/wangcanliang/source/keepalived-1* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/keepalived-1*
./configure --prefix=/webnew/keepalived  --mandir=/usr/local/share/man/ --with-kernel-dir=/usr/src/linux/
make
make install

tar zxvf /home/wangcanliang/source/nload* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/nload*
./configure --prefix=/webnew/nload
make
make install

cp /webnew/keepalived/sbin/keepalived /usr/sbin/
cp /webnew/keepalived/etc/* /etc/ -r

tar jxvf /home/wangcanliang/source/ocaml-3* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/ocaml-3*
./configure
make world opt
make install

tar zxvf /home/wangcanliang/source/unison-2* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/unison-2*
make UISTYLE=text
make install

useradd webuser
passwd webuser ('web@!@#@user')
su - webuser
ssh-keygen -t rsa
scp ~/.ssh/id_rsa.pub webuser@192.168.10.4:/home/webuser/
mv ~/id_rsa.pub ~/.ssh/authorized_keys 

service sshd restart
unison /var/htmlwww/ganwanpro/wwwroot/ ssh://webuser@192.168.1.190//var/htmlwww/ganwanpro/wwwroot

