#!/bin/bash
# Install berkerlydb, memcache, memcachedb, openldap

# Install berkerlydb
cd /home/source/
tar zxvf db-5* -C /home/spath/
cd /home/spath/db-5*/build_unix/
../dist/configure  --prefix=/opt/soft/berkerlydb
make && make install
echo "/opt/soft/berkerlydb/lib/" > /etc/ld.so.conf.d/berdeleyDB.conf
ldconfig


#Install memcachedb

#tar xzfv libevent-1.4.8-stable.tar.gz
#cd libevent1.4.8
#./configure --prefix=/opt/soft/libevent
#make && make install

cd /home/source/
wget http://memcachedb.googlecode.com/files/memcachedb-1.2.0.tar.gz
tar zxvf memcachedb* -C /home/spath/
cd /home/spath/memcachedb*
./configure --prefix=/opt/soft/memcachedb #--with-libevent=/opt/soft/libevent/
#vi Makefile '/usr/local/Berkeley-db' --> '/opt/soft/berkeley'
make; make install


# Install memcached
tar zxvf memcached-1.2.6.tar.gz
cd memcache-1.2.6
./configure --prefix=/opt/soft/memcache --with-libevent=/opt/soft/libevent
make && make install

cd /opt/soft/memcache/bin
./memcached -d -u daemon -m 512 127.0.0.1 -p 11211

LD_DEBUG=help ./memcached -v
LD_DEBUG=libs ./memcached -v 2>&1 > /dev/null | less

ln -s /opt/soft/libevent/lib/libevent-1.4.so.2 /usr/lib/
./memcached -d -u dameon -m 512 127.0.0.1 -p 11211


# Install openldap
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
