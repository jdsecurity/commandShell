!#/bin/bash
# Install Apache+Nginx

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