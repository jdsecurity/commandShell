!#/bin/bash
# Install Apache

wget http://mirrors.cnnic.cn/apache/apr/apr-1.4.8.tar.bz2
wget http://mirrors.cnnic.cn/apache/apr/apr-util-1.5.2.tar.bz2
wget http://mirrors.cnnic.cn/apache/apr/apr-iconv-1.2.1.tar.bz2
wget http://mirrors.cnnic.cn/apache/httpd/httpd-2.4.6.tar.bz2


tar jxvf /opt/sourcepackage/apr-1* -C /opt/source
cd /opt/source/apr-1*
./configure --prefix=/opt/soft/apr && make && make install

tar jxvf /opt/sourcepackage/apr-util* -C /opt/source
cd /opt/source/apr-util*
./configure --prefix=/opt/soft/apr-util --with-apr=/opt/soft/apr/bin/apr-1-config && make && make install

tar jxvf /opt/sourcepackage/apr-iconv* -C /opt/source
cd /opt/source/apr-iconv*
./configure --prefix=/opt/soft/apr-iconv --with-apr=/opt/soft/apr/bin/apr-1-config && make && make install

tar -jvxf /opt/sourcepackage/httpd* -C /opt/source
cd /opt/source/httpd*
cp /opt/source/apr-1* ./srclib/apr -r
cp /opt/source/apr-u* ./srclib/apr-util -r
./configure --prefix=/opt/soft/httpd \
  --with-ssl \
  --with-included-apr \
  --enable-ssl \
  --enable-dav \
  --enable-so \
  --enable-dav-fs \
  --enable-deflate=shared \
  --enable-expires=shared \
  --enable-headers=shared \
  --enable-rewrite=shared \
  --enable-static-support && make && make install

