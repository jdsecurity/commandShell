!#/bin/bash
# Install Zlib+freetype+jpeg+libpng+gd+libiconv+libmcrypt+mhash+mcrypt

mkdir /var/slog/{nagios,nginx,httpd,mysql,php,svn,openldap} -p
cd /opt/sourcepackage/

wget http://downloads.sourceforge.net/project/mcrypt/MCrypt/2.6.8/mcrypt-2.6.8.tar.gz
wget ftp://mcrypt.hellug.gr/pub/crypto/mcrypt/libmcrypt/libmcrypt-2.5.7.tar.gz
wget http://www.php.net/get/php-5.4.12.tar.bz2/from/am1.php.net/mirror
wget http://nginx.org/download/nginx-1.2.7.tar.gz

wget http://downloads.sourceforge.net/project/mcrypt/MCrypt/2.6.8/mcrypt-2.6.8.tar.gz
wget http://downloads.sourceforge.net/project/mcrypt/Libmcrypt/2.5.8/libmcrypt-2.5.8.tar.bz2
wget http://www.php.net/get/php-5.5.2.tar.bz2/from/am1.php.net/mirror
wget http://nginx.org/download/nginx-1.5.3.tar.gz
wget ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.32.tar.gz


tar zxvf /opt/sourcepackage/nginx* -C /opt/sourcepackage/
cd /opt/sourcepackage/nginx*
./configure --prefix=/opt/nginx && make && make install

tar jxvf /opt/sourcepackage/libmcrypt* -C /opt/source
cd /opt/source/libmcrypt*
./configure && make && make install


tar -jvxf /opt/sourcepackage/php-* -C /opt/source
cd /opt/source/php-*
./configure --prefix=/opt/soft/php \
--with-config-file-path=/opt/soft/php/etc \
--with-apxs2=/opt/soft/httpd/bin/apxs \
--with-mysql=/opt/soft/mysql \
--with-mysqli=/opt/soft/mysql/bin/mysql_config \
--with-gd \
--with-iconv \
--with-freetype-dir \
--with-jpeg-dir \
--with-png-dir \
--with-zlib \
--with-libxml-dir \
--enable-xml \
--enable-bcmath \
--enable-shmop \
--enable-sysvsem \
--enable-inline-optimization \
--with-curl \
--enable-mbregex \
--enable-mbstring \
--enable-ftp \
--enable-gd-native-ttf \
--with-openssl \
--enable-pcntl \
--enable-sockets \
--with-xmlrpc \
--enable-zip \
--enable-soap \
--without-pear \
--with-gettext \
--enable-session \
--with-mcrypt && make && make install 
mkdir /usr/local/php5/etc
cp php.ini-production /usr/local/php5/etc/php.ini #复制php配置文件到安装目录
rm -rf /etc/php.ini #删除系统自带的配置文件
ln -s /usr/local/php5/etc/php.ini /etc/php.ini #创建配置文件软链接



/usr/sbin/groupadd www
/usr/sbin/useradd -g www www
ulimit -SHn 65535

tar zxvf /opt/sourcepackage/pcre* -C /opt/source
cd /opt/source/pcre*
./configure --prefix=/opt/soft/pcre && make && make install

tar zxvf /opt/sourcepackage/nginx-1.5* -C /opt/source
cd /opt/source/nginx-1.5*
./configure \
--user=www \
--group=www \
--prefix=/opt/soft/nginx \
--with-http_stub_status_module \
--with-http_ssl_module \
--with-pcre=/opt/source/pcre-8.32 \
--with-http_realip_module \
--with-http_image_filter_module
make
make install

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


curl -O http://www6.atomicorp.com/channels/atomic/centos/6/x86_64/RPMS/atomic-release-1.0-14.el6.art.noarch.rpm
rpm -Uvh atomic-release-1.0-14.el6.art.noarch.rpm
curl -L https://get.rvm.io | bash -s stable --ruby
yum list available 'ruby*'
source /usr/local/rvm/scripts/rvm
rvm install 1.9.3
rvm use 1.9.3
rvm rubygems latest 

rvm use 1.9.3
rvm rubygems latest --verify-downloads 1
cd /var/htmlwww/
git clone git://github.com/imathis/octopress.git octopress
cd octopress/
gem install bundler
rbenv rehash
bundle install
bundle show
rake install
