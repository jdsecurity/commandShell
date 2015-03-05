!#/bin/bash
# Install Zlib+freetype+jpeg+libpng+gd+libiconv+libmcrypt+mhash+mcrypt

cd /opt/sourcepackage/
wget http://www.webdav.org/neon/neon-0.29.6.tar.gz
wget http://www.webdav.org/neon/neon-0.25.4.tar.gz
wget http://mirror.bjtu.edu.cn/apache/subversion/subversion-1.7.8.tar.bz2
wget http://www.sqlite.org/sqlite-autoconf-3071502.tar.gz
wget http://www.roland-riegel.de/nload/nload-0.7.4.tar.gz

tar zxvf /opt/sourcepackage/neon-0.29* 
cd /opt/source/neon-0.29*
./configure --prefix=/opt/soft/neon
make && make install

tar jxvf /opt/sourcepackage/subversion* -C /opt/source
cd /opt/source/subversion*
tar zxvf /opt/sourcepackage/sqlite* 
mv sqlite* sqlite-amalgamation
./configure --prefix=/opt/soft/svn \
--with-apxs=/opt/soft/httpd/bin/apxs \
--with-apr=/opt/soft/apr/bin/apr-1-config \
--with-apr-util=/opt/soft/apr-util \
--with-neon=/opt/soft/neon \
--with-ssl && make && make install



tar zxvf /opt/sourcepackage/nload* -C /opt/source
cd /opt/source/nload*
./configure --prefix=/opt/soft/nload  && make && make install

rpm -Uvh http://repo.webtatic.com/yum/el6/latest.rpm
yum install --enablerepo=webtatic git-all
yum install git --disableexcludes=main

cd /opt/sourcepackage/
curl -O https://pypi.python.org/packages/source/v/virtualenv/virtualenv-1.10.1.tar.gz
tar zxvf virtualenv-1.10.1.tar.gz -C /opt/source
cd /opt/source/virtualenv*
python setup.py install

cd /opt/sourcepackage/
curl -O https://pypi.python.org/packages/source/s/setuptools/setuptools-1.0.tar.gz
tar zxvf setuptools-* -C /opt/source
cd /opt/source/setuptools-*
python setup.py build
python setup.py install

cd /opt/sourcepackage/
curl -O https://pypi.python.org/packages/source/p/pip/pip-1.4.1.tar.gz
tar zxvf pip-1.4* -C /opt/source
cd /opt/source/pip-1*
python setup.py install

yum install sqlite-devel
yum update libxml2
yum install libxslt-devel
yum install python-devel
yum install python-lxml

yum install git-core

pip install django-celery

cd /opt/sourcepackage/
curl -O https://www.djangoproject.com/m/releases/1.5/Django-1.5.2.tar.gz
tar zxvf Django-1.5* -C /opt/source
cd /opt/source/Django-1.5*
python setup.py install

cd /opt/sourcepackage/
curl -O https://pypi.python.org/packages/source/d/django-extensions/django-extensions-1.1.1.tar.gz
tar zxvf django-extensions* -C /opt/source
cd /opt/source/django-extensions*
python setup.py install

cd /opt/sourcepackage/
curl -O https://pypi.python.org/packages/source/d/django-celery/django-celery-3.0.21.tar.gz
tar zxvf django-celery* -C /opt/source
cd /opt/source/django-celery*
/var/htmlwww/readthedocs/rtd/bin/python2.6 setup.py install

cd /opt/sourcepackage/
curl -O https://pypi.python.org/packages/source/d/doc2dash/doc2dash-1.1.0.tar.gz#md5=03d52c30c411184f60e4f797bfc9d9b4
tar zxvf doc2dash-* -C /opt/source
cd /opt/source/doc2dash*
python setup.py install

cd /opt/sourcepackage/
wget https://www.kernel.org/pub/software/scm/git/git-1.8.3.tar.bz2
tar jxvf git-1.8.3.tar.bz2 -C /opt/source
cd /opt/source/git-*
./configure ; make ; make install



yum -y install tk zlib-devel openssl-devel perl cpio expat-devel gettext-devel openssl zlib curl install autoconf perl-devel

wget http://www.codemonkey.org.uk/projects/git-snapshots/git/git-latest.tar.gz
tar xzvf git-latest.tar.gz
cd git-{date}
autoconf
./configure --with-curl=/usr/local
make 
make install 