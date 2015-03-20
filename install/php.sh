!#/bin/bash
# Install Zlib+freetype+jpeg+libpng+gd+libiconv+libmcrypt+mhash+mcrypt

cd /opt/sourcepackage/
wget http://cn2.php.net/distributions/php-5.6.6.tar.bz2
#wget http://downloads.sourceforge.net/project/mcrypt/MCrypt/2.6.8/mcrypt-2.6.8.tar.gz
#wget http://downloads.sourceforge.net/project/mcrypt/Libmcrypt/2.5.8/libmcrypt-2.5.8.tar.bz2

#tar jxvf /opt/sourcepackage/libmcrypt* -C /opt/source
#cd /opt/source/libmcrypt*
#./configure && make && make install

tar jxvf /opt/sourcepackage/php-5* -C /opt/source
cd /opt/source/php-*
./configure --prefix=/opt/soft/php \
--with-apxs2=/opt/soft/httpd/bin/apxs \
--with-config-file-path=/opt/soft/php/etc \
--with-curl \
--with-freetype-dir \
--with-gd \
--with-gettext \
--with-iconv-dir \
--with-jpeg-dir \
--with-libxml-dir \
--with-mcrypt \
--with-mysql=/opt/soft/mysql \
--with-mysqli=/opt/soft/mysql/bin/mysql_config \
--with-openssl \
--with-png-dir \
--with-xmlrpc \
--with-zlib \
--without-pear \
--disable-fileinfo \
--enable-bcmath \
--enable-ftp \
--enable-gd-native-ttf \
--enable-inline-optimization \
--enable-mbregex \
--enable-mbstring \
--enable-pcntl \
--enable-shmop \
--enable-session \
--enable-sockets \
--enable-soap \
--enable-xml \
--enable-zip \
--enable-sysvsem \
&& make && make install 

#--with-ldap \
#--with-ldap-sasl \
#--with-mhash \
#--without-pear

#rm -rf /etc/php.ini 
mkdir /opt/soft/php/etc
cp php.ini-production /opt/soft/php/etc/php.ini
#ln -s /usr/local/php5/etc/php.ini /etc/php.ini #创建配置文件软链接
echo 'export PATH="/opt/soft/php/bin:$PATH"' >> ~/.bashrc
cd /opt/soft/tools
wget https://getcomposer.org/download/1.0.0-alpha9/composer.phar
wget https://phar.phpunit.de/phpunit.phar

/usr/sbin/groupadd www
/usr/sbin/useradd -g www www
ulimit -SHn 65535

tar jxvf /opt/sourcepackage/php-5* -C /opt/source
mv /opt/source/php-5* /opt/source/phpcgi
cd /opt/source/phpcgi
 export LD_LIBRARY_PATH=/lib/:/usr/lib/:/usr/local/lib:/lib64/:/usr/lib64:/usr/local/lib64  
./configure \
--prefix=/opt/soft/phpcgi \
--enable-opcache=no \
--with-config-file-path=/opt/soft/phpcgi/etc \
--with-mysql=/opt/soft/mysql \
--with-mysqli=/opt/soft/mysql/bin/mysql_config \
--with-iconv-dir \
--with-freetype-dir \
--with-jpeg-dir \
--with-png-dir \
--with-zlib \
--with-libxml-dir= \
--enable-xml \
--disable-rpath \
--enable-bcmath \
--enable-shmop \
--enable-sysvsem \
--enable-inline-optimization \
--with-curl \
--enable-mbregex \
--enable-fpm \
--enable-mbstring \
--with-mcrypt \
--with-gd \
--enable-gd-native-ttf \
--with-openssl \
--with-mhash \
--enable-pcntl \
--enable-sockets \
--with-xmlrpc \
--enable-zip \
--enable-soap \
--enable-opcache \
--with-pdo-mysql
make
make install
cp php.ini-development /Data/apps/php/etc/php.ini
cd ../

ln -s /usr/local/mysql/lib/libmysqlclient.so.18  /usr/lib64/
make;
make install;

cd /opt/sourcepackage
wget http://pecl.php.net/get/xhprof-0.9.4.tgz
tar zxvf /opt/sourcepackage/xhprof* -C /opt/source/
cd /opt/source/xhprof*/extension/
/opt/soft/php/bin/phpize
./configure --with-php=/opt/soft/php/bin/php-config
make; make install
./configure --with-php-config=/opt/soft/php/bin/php-config
make; make install

yum list available 'graphviz*'
yum install 'graphviz-php'  

