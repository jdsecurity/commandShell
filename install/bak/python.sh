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

#yum install sqlite-devel
#yum update libxml2
#yum install libxslt-devel
#yum install python-devel
#yum install python-lxml

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
