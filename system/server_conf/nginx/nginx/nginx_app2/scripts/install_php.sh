CHOST="i686-pc-linux-gnu"
CFLAGS="-march=prescott -O3 -pipe -fomit-frame-pointer"
CXXFLAGS="${CFLAGS}"
./configure \
        "--prefix=/usr/local/php-fcgi" \
        "--enable-fastcgi" \
        "--enable-fpm" \
        "--enable-discard-path" \
        "--enable-force-cgi-redirect" \
        "--with-config-file-path=/usr/local/php-fcgi/etc" \
        "--enable-zend-multibyte" \
        "--with-mysql=/usr/local/mysql" \
        "--with-libxml-dir" \
        "--with-xmlrpc" \
        "--with-gd=/usr/local/gd2" \
        "--with-jpeg-dir" \
        "--with-png-dir" \
        "--with-bz2" \
        "--with-freetype-dir" \
        "--with-iconv-dir" \
        "--with-zlib-dir" \
        "--with-curl" \
        "--with-curlwrappers" \
        "--with-openssl" \
        "--with-mcrypt" \
        "--with-mhash" \
        "--enable-pcntl" \
        "--enable-sockets" \
        "--enable-sysvsem" \
        "--enable-inline-optimization" \
        "--enable-soap" \
        "--enable-gd-native-ttf" \
        "--enable-ftp" \
        "--enable-mbstring" \
        "--enable-exif" \
        "--disable-debug" \
        "--disable-ipv6" 
 
#sed -i 's#-lz -lm -lxml2 -lz -lm -lxml2 -lz -lm -lcrypt#& -liconv#' Makefile       
make ZEND_EXTRA_LIBS='-liconv' 
make install
cp php.ini-dist /usr/local/php-fcgi/etc/php.ini