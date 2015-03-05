!#/bin/bash
# Install PHP（cgi+module）

#wget http://php-fpm.org/downloads/php-5.2.13-fpm-0.5.13.diff.gz
#gzip -dc php-5.2.13-fpm-0.5.13.diff.gz | patch -p1

#tar jxvf /home/wangcanliang/source/php-5.2.17* -C /home/wangcanliang/spath
#cd /home/wangcanliang/spath/php-5.2.17*

tar jxvf /home/wangcanliang/source/php-5.3* -C /home/wangcanliang/spath
cp /home/wangcanliang/spath/php-5* /home/wangcanliang/spath/phpcgi -r
cd /home/wangcanliang/spath/phpcgi
./configure --prefix=/webnew/phpcgi \
--with-config-file-path=/webnew/phpcgi/etc \
--with-mysql=/webnew/mysql \
--with-mysqli=/webnew/mysql/bin/mysql_config \
--without-iconv \
--with-freetype-dir=/webnew/freetype \
--with-jpeg-dir=/webnew/jpeg \
--with-png-dir=/webnew/libpng \
--with-zlib \
--with-libxml-dir=/usr \
--enable-xml \
--disable-rpath \
--enable-safe-mode \
--enable-bcmath \
--enable-shmop \
--enable-sysvsem \
--enable-inline-optimization \
--with-curl \
--with-curlwrappers \
--enable-mbregex \
--enable-fpm \
--enable-mbstring \
--with-mcrypt=/webnew/libmcrypt \
--with-gd=/webnew/gd2/ \
--enable-gd-native-ttf \
--with-openssl \
--with-mhash \
--enable-pcntl \
--enable-sockets \
--with-ldap \
--with-ldap-sasl \
--with-xmlrpc \
--enable-zip \
--enable-soap \
--without-pear
make
make install

cd /home/wangcanliang/spath/php-*
./configure --prefix=/webnew/php \
--with-config-file-path=/webnew/php/etc \
--with-apxs2=/webnew/httpd/bin/apxs \
--with-mysql=/webnew/mysql \
--with-mysqli=/webnew/mysql/bin/mysql_config \
--with-iconv-dir=/webnew/iconv \
--with-freetype-dir=/webnew/freetype \
--with-jpeg-dir=/webnew/jpeg \
--with-png-dir=/webnew/libpng \
--with-zlib \
--with-libxml-dir=/usr \
--enable-xml \
--disable-rpath \
--enable-safe-mode \
--enable-bcmath \
--enable-shmop \
--enable-sysvsem \
--enable-inline-optimization \
--with-curl \
--with-curlwrappers \
--enable-mbregex \
--enable-mbstring \
--with-mcrypt=/webnew/libmcrypt \
--with-gd=/webnew/gd2/ \
--enable-gd-native-ttf \
--with-openssl \
--with-mhash \
--enable-pcntl \
--enable-sockets \
--with-ldap \
--with-ldap-sasl \
--with-xmlrpc \
--enable-zip \
--enable-soap \
--without-pear
make
make install

NT, TERM 立刻终止
QUIT 平滑终止
USR1 重新打开日志文件
USR2 平滑重载所有worker进程并重新载入配置和二进制模块

示例：
php-fpm 关闭：
kill -INT `cat /usr/local/php/var/run/php-fpm.pid`
php-fpm 重启：
kill -USR2 `cat /usr/local/php/var/run/php-fpm.pid`

查看php-fpm进程数：

ps aux | grep -c php-fpm


tar jxvf /home/wangcanliang/source/ZendOptimizer* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/ZendOptimizer*

cd ext/gd/
/webnew/phpcgi/bin/phpize
./configure --with-php-config=/webnew/php/bin/php-config --with-jpeg-dir=/webnew/jpeg/ --with-png-dir=/webnew/libpng/ --with-ttf --with-zlib=/webnew/zlib --with-freetype-dir=/webnew/freetype

make
make install

vi /web/phpcgi/lib/php.ini
	extension=/webnew/phpcgi/lib/php/extensions/no-debug-non-zts-20090626/gd.so
define('UC_FOUNDERPW', 'cf381785892ea8771dfb0bd78b707ec5');
define('UC_FOUNDERSALT', '107085');

yum install libssh2 libssh2-devel
wget http://pecl.php.net/get/ssh2-0.10.tgz
tar zxvf ssh2*.tgz
cd ssh*
vi ssh2.c
	LINE 480:
	search and change following line:
	#if LIBSSH2_APINO < 200402301450
	...
	#else

	to:
	#if (define(LIBSSH2_APINO) && LIBSSH2_APINO < 200412301450)
	...
	#else /* if LIBSSH2_APINO is not defined its v0.14 or higher. no problem! */

	LINE 1216:
	search and change following line:
	#if (LIBSSH2_APINO > 200503221619)

	to:
	#if (defined(LIBSSH2_APINO) && (LIBSSH2_APINO > 200503221619)) || (defined(LIBSSH2_VERSION_NUM) && LIBSSH2_VERSION_NUM >= 0x001000)

phpize ./configure --with-ssh2
make
cp modules/ssh2.so /usr/lib/php/modules/

vi php.ini
	add:
	extension=ssh2.so

php -i | grep ssh2


tar jxvf /home/wangcanliang/source/scws-1* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/scws-1*
./configure --prefix=/webnew/scws
make
make install

tar jxvf /home/wangcanliang/source/scws-d* -C /webnew/scws/etc

cd /home/wangcanliang/spath/scws-1*/phpext/
/webnew/phpcgi/bin/phpize 
./configure --with-scws=/webnew/scws/ --with-php-config=/webnew/phpcgi/bin/php-config 
make
make install