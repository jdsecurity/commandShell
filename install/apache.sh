!#/bin/bash
# Install Apache

wget ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.36.tar.gz
wget http://mirrors.hust.edu.cn/apache/apr/apr-1.5.1.tar.bz2
wget http://mirrors.hust.edu.cn/apache/apr/apr-util-1.5.4.tar.bz2
wget http://mirrors.hust.edu.cn/apache/apr/apr-iconv-1.2.1.tar.bz2
wget http://mirrors.hust.edu.cn/apache/httpd/httpd-2.4.12.tar.bz2

tar zxvf /opt/sourcepackage/pcre* -C /opt/source
cd /opt/source/pcre*
./configure --prefix=/opt/soft/pcre && make && make install

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
  --with-pcre=/opt/soft/pcre \
  --enable-ssl \
  --enable-dav \
  --enable-so \
  --enable-dav-fs \
  --enable-deflate=shared \
  --enable-expires=shared \
  --enable-headers=shared \
  --enable-rewrite=shared \
  --enable-static-support && make && make install

