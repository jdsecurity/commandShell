CHOST="x86_64-pc-linux-gnu"
CFLAGS="-march=nocona -O3 -pipe"
CXXFLAGS="${CFLAGS}"
./configure \
        "--prefix=/usr/local/mysql" \
        "--localstatedir=/data/mysql/data" \
        "--with-comment=Source" \
        "--with-server-suffix=-Linuxtone.Org" \
        "--with-mysqld-user=mysql" \
        "--without-debug" \
        "--with-big-tables" \
        "--with-charset=gbk" \
        "--with-collation=gbk_chinese_ci" \
        "--with-extra-charsets=all" \
        "--with-pthread" \
        "--enable-static" \
        "--enable-thread-safe-client" \
        "--with-client-ldflags=-all-static" \
        "--with-mysqld-ldflags=-all-static" \
        "--enable-assembler" \
        "--with-plugins=all" \
        "--without-ndb-debug"
make
make install
useradd mysql -d /data/mysql -s /sbin/nologin
/usr/local/mysql/bin/mysql_install_db --user=mysql
cd /usr/local/mysql
chown -R root:mysql .
mkdir -p /data/mysql/data
chown -R mysql /data/mysql/data
cp share/mysql/my-huge.cnf /etc/my.cnf
cp share/mysql/mysql.server /etc/rc.d/init.d/mysqld
chmod 755 /etc/rc.d/init.d/mysqld
chkconfig --add mysqld
/etc/rc.d/init.d/mysqld start

cd /usr/local/mysql/bin
for i in *; do ln -s /usr/local/mysql/bin/$i /usr/bin/$i; done