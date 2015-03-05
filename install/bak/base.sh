!#/bin/bash
# Install Zlib+freetype+jpeg+libpng+gd+libiconv+libmcrypt+mhash+mcrypt

mkdir /var/slog/{nagios,nginx,httpd,mysql,php,svn,openldap} -p

tar zxvf /home/wangcanliang/source/zlib-1.2.4* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/zlib*
./configure --prefix=/webnew/zlib 
make
make install

tar jxvf /home/wangcanliang/source/freetype-2* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/freetype*
./configure --prefix=/webnew/freetype 
make
make install

#cp /usr/share/libtool/{config.sub,config.guess} ./ #（有时需要在`cd`命令后使用该命令）
mkdir -p /webnew/jpeg/{bin,lib,include,man1,man/man1}
tar zxvf /home/wangcanliang/source/jpegsrc.* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/jpeg*
./configure --prefix=/webnew/jpeg --enable-shared --enable-static
make
make install

tar jxvf /home/wangcanliang/source/libpng* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/libpng*
./configure --prefix=/webnew/libpng 
make
make install

tar zxvf /home/wangcanliang/source/gd* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/gd*
# vi gd_png.c
./configure --prefix=/webnew/gd2 \
--with-jpeg=/webnew/jpeg \
--with-png=/webnew/libpng \
--with-freetype=/webnew/freetype \
--with-zlib=/webnew/zlib 
make
make install

tar zxvf /home/wangcanliang/source/libiconv* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/libiconv*
./configure --prefix=/webnew/iconv 
make
make install

tar jxvf /home/wangcanliang/source/libmcrypt* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/libmcrypt*
./configure --prefix=/webnew/libmcrypt
make
make install
/sbin/ldconfig
cd  libltdl
./configure --prefix=/webnew/libmcrypt --enable-ltdl-install
make
make install

tar jxvf /home/wangcanliang/source/mhash* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/mhash*
./configure --prefix=/webnew/mhash 
make
make install

#ln -s /webnew/libmcrypt/lib/libmcrypt.la /usr/lib/libmcrypt.la
#ln -s /webnew/libmcrypt/lib/libmcrypt.so /usr/lib/libmcrypt.so
#ln -s /webnew/libmcrypt/lib/libmcrypt.so.4 /usr/lib/libmcrypt.so.4
#ln -s /webnew/libmcrypt/lib/libmcrypt.so.4.4.8 /usr/lib/libmcrypt.so.4.4.8
ln -s /webnew/mhash/lib/libmhash.a /webnew/libmcrypt/lib/libmhash.a
ln -s /webnew/mhash/lib/libmhash.la /webnew/libmcrypt/lib/libmhash.la
ln -s /webnew/mhash/lib/libmhash.so /webnew/libmcrypt/lib/libmhash.so
ln -s /webnew/mhash/lib/libmhash.so.2 /webnew/libmcrypt/lib/libmhash.so.2
ln -s /webnew/mhash/lib/libmhash.so.2.0.1 /webnew/libmcrypt/lib/libmhash.so.2.0.1

tar zxvf /home/wangcanliang/source/mcrypt* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/mcrypt*
CFLAGS="-I/webnew/mhash/include -L/webnew/mhash/lib" \
LD_LIBRARY_PATH=/webnew/libmcrypt/lib \
./configure --prefix=/webnew/mcrypt \
--with-libiconv-prefix=/webnew/iconv \
--with-libmcrypt-prefix=/webnew/libmcrypt \
--with-libintl-prefix=/webnew/libmcrypt
make
make install
