!#/bin/bash
# Install Git+python

rpm -Uvh http://repo.webtatic.com/yum/centos/5/latest.rpm
yum install --enablerepo=webtatic git-all

wget  http://www.python.org/ftp/python/3.2.3/Python-3.2.3.tar.bz2
tar jfvx /home/wangcanliang/source/Python-3* -C /home/wangcanliang/spath
cd /home/wangcanliang/spath/Python*
./configure
make all
make install
make clean
make distclean

mv /usr/bin/python /usr/bin/python-bak
ln -s /usr/local/bin/python3.0 /usr/bin/python
vim /usr/bin/yum 
# /usr/bin/python2.4

#curl http://python-distribute.org/distribute_setup.py | python

yum install python-setuptools
#yum install python-pygments
easy_install -U Sphinx