!#/bin/bash
# some useful but not necessary

yum install wget

# Install nload
wget http://www.roland-riegel.de/nload/nload-0.7.4.tar.gz
tar zxvf /opt/sourcepackage/nload* -C /opt/source
cd /opt/source/nload*
./configure --prefix=/opt/soft/nload  && make && make install

# inotify-tools
cd /opt/source/
wget http://github.com/downloads/rvoicilas/inotify-tools/inotify-tools-3.14.tar.gz
tar zxvf /opt/source/inotify-tools* -C /opt/sourcepackage/
cd /opt/sourcepackage/inotify-tools*
./configure --prefix=/usr && make && make install

# rar
wget http://www.skycn.com/soft/3455.html
tar zxvf /home/wangcanliang/source/rarlinux-4* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/rar*
make install

#rar x *.rar */
#cp rar/rar_static /usr/local/bin/rar


