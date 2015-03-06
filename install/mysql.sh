!#/bin/bash
# Install Mysql+berkeleyDb+openldap

# install 5.5+ version
cd /opt/sourcepackage
wget http://www.cmake.org/files/v2.8/cmake-2.8.11.2.tar.gz
wget http://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.13.tar.gz

tar zxvf /opt/sourcepackage/cmake* -C /opt/source
cd /opt/source/cmake*
./configure && make && make install

useradd mysql -s /bin/false
tar zxvf /opt/sourcepackage/mysql* -C /opt/source
cd /opt/source/mysql*
cmake . \
  -DCMAKE_INSTALL_PREFIX=/opt/soft/mysql \
  -DMYSQL_DATADIR=/var/slog/mysql/data \
  -DSYSCONFDIR=/opt/soft/mysql/etc \
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
#/opt/soft/mysqld_safe --defaults-file=/opt/soft/mysql/etc/my.cnf
/opt/soft/mysql/bin/mysqladmin -uroot password 'new-password'
#/opt/soft/mysql/bin/mysqladmin -uroot -p password '你的新密码'
#/opt/soft/mysql/bin/mysqladmin -uroot password oldpass "newpass"
#/opt/soft/mysql/bin/mysqladmin -uroot flush-privileges password "data@!*^@root";

cd /opt/sourcepackage
wget http://downloads.sourceforge.net/project/phpmyadmin/phpMyAdmin/4.3.11.1/phpMyAdmin-4.3.11.1-all-languages.zip
unzip /opt/sourcepackage/phpMyAdmin-4*
mv phpMyAdmin-4*/ /var/htmlwww/common/dphp


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
/opt/source/mysql/bin/mysql_install_db --user=mysql
#chown -R mysql.mysql /var/slog/mysql/data

# the config file of mysql my.ini
