!#/bin/bash
# Install Mysql+berkeleyDb+openldap

# install 5.5+ version
wget http://www.cmake.org/files/v2.8/cmake-2.8.11.2.tar.gz
wget http://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.13.tar.gz/from/http://cdn.mysql.com/

tar zxvf /opt/sourcepackage/cmake* -C /opt/source
cd /opt/source/cmake*
./configure && make && make install


useradd mysql -s /bin/false
tar zxvf /opt/sourcepackage/mysql* -C /opt/source
cd /opt/source/mysql*
cmake . \
  -DCMAKE_INSTALL_PREFIX=/opt/soft/mysql \
  -DMYSQL_DATADIR=/var/slog/mysql/data \
  -DSYSCONFDIR=/opt/soft/mysql/etc 

  -DMYSQL_UNIX_ADDR=/opt/soft/mysql/mysqld.sock \  
  -DWITH_INNOBASE_STORAGE_ENGINE=1 \  
  -DENABLED_LOCAL_INFILE=1 \  
  -DMYSQL_TCP_PORT=3306 \  
  -DCMAKE_THREAD_PREFER_PTHREAD=1 \  
  -DEXTRA_CHARSETS=all \  
  -DDEFAULT_CHARSET=utf8 \  
  -DDEFAULT_COLLATION=utf8_general_ci \  
  -DMYSQL_UNIX_ADDR=/opt/soft/mysql/mysql.sock \  
  -DWITH_DEBUG=0 
make && make install

cd /opt/soft/mysql
./scripts/mysql_install_db --user=mysql --datadir=/var/slog/mysql/data/
/opt/source/mysql/bin/mysqladmin -uroot password 'new-password'
/opt/source/mysql/bin/mysqladmin -uroot -p password '你的新密码'
/opt/source/mysql/bin/mysqladmin -uroot password oldpass "newpass"
/opt/source/mysql/bin/mysqladmin -uroot flush-privileges password "data@!*^@root";

wget http://downloads.sourceforge.net/project/phpmyadmin/phpMyAdmin/4.0.5/phpMyAdmin-4.0.5-all-languages.tar.bz2
tar jxvf /opt/sourcepackage/phpMyAdmin-4* -C /var/htmlwww/
mv /var/htmlwww/phpMyAdmin-4*/ /var/htmlwww/dphp

# install the 5.1* version

tar zxvf /opt/sourcepackage/mysql-5.1* -C /opt/source
cd /opt/source/mysql*
./configure --prefix=/opt/soft/mysql \
  --localstatedir=/var/slog/mysql/data \
  --enable-assembler \
  --with-extra-charsets=complex \
  --enable-thread-safe-client \
  --with-big-tables --with-readline \
  --with-ssl \
  --with-embedded-server \
  --enable-local-infile \
  --with-plugins=innobase
make; make install

useradd -r mysql
#rm -f /etc/my.cnf
/opt/source/mysql/bin/mysql_install_db -user=mysql
#chown -R mysql.mysql /var/slog/mysql/data

# the config file of mysql my.ini


tar zxvf /opt/sourcepackage/db-4.* -C /opt/source
cd /opt/source/db-4.*/build_unix
../dist/configure --prefix=/opt/soft/berkeleydb 
make; make install

tar zxvf /opt/sourcepackage/openldap-stable* -C /opt/source
cd /opt/source/openldap*
CPPFLAGS="-I/opt/source/berkeleydb/include"
export CPPFLAGS
LDFLAGS="-L/usr/local/lib -L/opt/source/berkeleydb/lib -R/opt/source/berkeleydb/lib"
export LDFLAGS
LD_LIBRARY_PATH="/opt/source/berkeleydb/lib"
export LD_LIBRARY_PATH
./configure --prefix=/opt/source/openldap --enable-ldbm 
make depend
make
make test
make install
