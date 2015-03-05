#!/bin/bash

cd /home/source/
#wget htt
tar zxvf db-5* -C /home/spath/
cd /home/spath/db-5*/build_unix/
../dist/configure  --prefix=/web/berkerlydb
make && make install
echo "/web/berkerlydb/lib/" > /etc/ld.so.conf.d/berdeleyDB.conf
ldconfig

cd /home/source/
wget http://memcachedb.googlecode.com/files/memcachedb-1.2.0.tar.gz
tar zxvf memcachedb* -C /home/spath/
cd /home/spath/memcachedb*
./configure --prefix=/web/memcachedb --with-libevent=/web/libevent/
#vi Makefile '/usr/local/Berkeley-db' --> '/web/berkeley'
make; make install

tar xzfv libevent-1.4.8-stable.tar.gz
cd libevent1.4.8
./configure --prefix=/web/libevent
make && make install

tar zxvf memcached-1.2.6.tar.gz
cd memcache-1.2.6
./configure --prefix=/web/memcache --with-libevent=/web/libevent
make && make install

cd /web/memcache/bin
./memcached -d -u daemon -m 512 127.0.0.1 -p 11211

LD_DEBUG=help ./memcached -v
LD_DEBUG=libs ./memcached -v 2>&1 > /dev/null | less

ln -s /web/libevent/lib/libevent-1.4.so.2 /usr/lib/

./memcached -d -u dameon -m 512 127.0.0.1 -p 11211


