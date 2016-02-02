!#/bin/bash
# Install Subversion+Nagios

cd /opt/sourcepackage/
wget http://apache.dataguru.cn/subversion/subversion-1.8.11.tar.bz2
wget http://www.sqlite.org/2015/sqlite-autoconf-3080803.tar.gz
#wget http://serf.googlecode.com/files/serf-1.2.1.tar.bz2  
wget http://xz1.cr173.com/soft1/serf-1.2.1.tar.bz2

# after 1.8.0 no neon
#wget http://www.webdav.org/neon/neon-0.29.6.tar.gz
#yum install libxml2
#yum install libxml2-devel
#tar zxvf /opt/sourcepackage/neon-0.29* 
#cd /opt/source/neon-0.29*
#./configure --prefix=/opt/soft/neon
#make && make install

tar zxvf /opt/sourcepackage/sqlite-autoconf-3* -C /opt/source/
cd /opt/source/sqlite-autoconf-3*/
./configure --prefix=/opt/soft/sqlite
make && make install

tar jxvf /opt/sourcepackage/serf* -C /opt/source
cd /opt/source/serf*
./configure --prefix=/opt/soft/serf \
--with-apr=/opt/soft/apr \
--with-apr-util=/opt/soft/apr-util 
make && make install

#tar zxvf /opt/sourcepackage/sqlite* 
#mv sqlite* sqlite-amalgamation
tar jxvf /opt/sourcepackage/subversion* -C /opt/source
cd /opt/source/subversion*
./configure --prefix=/opt/soft/svn \
--with-apxs=/opt/soft/httpd/bin/apxs \
--with-apr=/opt/soft/apr/bin/apr-1-config \
--with-apr-util=/opt/soft/apr-util \
--with-openssl --with-zlib --enable-maintainer-mode \
--with-sqlite=/opt/soft/sqlite \
--with-serf=/opt/soft/serf \
&& make && make install

cp /opt/soft/svn/libexec/mod_* /opt/soft/httpd/modules/
mkdir /opt/soft/svn/conf
echo '<Location /svn>
    DAV svn
    SVNParentPath /var/svn
    AuthType Basic
    AuthName "Subversion reposi"
    AuthUserFile /opt/soft/svn/conf/passwd
    #AuthzSVNAccessFile /opt/soft/svn/conf/accessfile
    AuthzSVNAccessFile /opt/soft/svn/conf/authz
    Require valid-user
</Location>' > /opt/soft/httpd/conf/extra/svn.conf

echo '
[aliases]
[groups]
adminusers = adminsvn
commonusers = wangcan
[test:/]
@adminusers = rw
@commonusers = r
' >> /opt/soft/svn/conf/authz

/opt/soft/httpd/bin/htpasswd -c /opt/soft/svn/conf/passwd adminsvn

cd /var/svn/
/opt/soft/svn/bin/svnadmin create ./test
chown daemon.daemon test
chown daemon.daemon test/db -R


# Install git
#rpm -Uvh http://repo.webtatic.com/yum/el6/latest.rpm
#yum install --enablerepo=webtatic git-all
#yum install git-core
#yum install git --disableexcludes=main

#yum -y install \
#  tk zlib-devel openssl-devel perl cpio expat-devel gettext-devel \
#  openssl zlib curl install autoconf perl-devel

cd /opt/sourcepackage/
#wget https://www.kernel.org/pub/software/scm/git/git-2.5.0.tar.gz
wget https://www.kernel.org/pub/software/scm/git/git-htmldocs-2.6.4.tar.gz
tar zxvf /opt/sourcepackage/git-2* -C /opt/source
cd /opt/source/git-*
#autoconf
./configure --with-curl=/usr/local
make && make install 
