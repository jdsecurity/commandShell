!#/bin/bash
# Install Subversion+Nagios

#tar zxvf /home/wangcanliang/source/sqlite-autoconf-3070701.tar.gz -C /home/wangcanliang/spath/
#cd /home/wangcanliang/spath/sqlite-autoconf-3070701/
#./configure --prefix=/webnew/sqlite
#make
#make install

# yum install libxml2
# yum install libxml2-devel
tar zxvf /home/wangcanliang/source/sqlite-autoconf-3070701.tar.gz -C /home/wangcanliang/spath/
tar jxvf /home/wangcanliang/source/subversion-1.6.17.tar.bz2 -C /home/wangcanliang/spath/
tar jxvf /home/wangcanliang/source/subversion-deps-1.6.17.tar.bz2 -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/subversion-1.6.17/
mv sqlite-amalgamation/ sqlite-amalgamation-old
mv ../sqlite-autoconf-*/ sqlite-amalgamation
./configure --prefix=/webnew/svn \
--with-apxs=/webnew/httpd/bin/apxs \
--with-ssl 
#--with-sqlite=/webnew/sqlite/
make
make install

mkdir /webnew/svn/conf
echo '<Location /svn>
    DAV svn
    SVNParentPath /var/svn
    AuthType Basic
    AuthName "Subversion reposi"
    AuthUserFile /webnew/svn/conf/passwd
    #AuthzSVNAccessFile /webnew/svn/conf/accessfile
    AuthzSVNAccessFile /webnew/svn/conf/authz
    Require valid-user
</Location>' > /webnew/httpd/conf/extra/svn.conf

echo '
[aliases]
[groups]
adminusers = adminsvn
commonusers = wangcan
[test:/]
@adminusers = rw
@commonusers = r
' >> /webnew/svn/conf/authz

/webnew/httpd/bin/htpasswd -c /webnew/svn/conf/passwd adminsvn

cd /var/svn/
/webnew/svn/bin/svnadmin create ./test
chown daemon.daemon test
chown daemon.daemon test/db -R

groupadd nagios
useradd -g nagios -d /webnew/nagios -s /bin/false nagios
chmod 755 /webnew/nagios

tar zxvf /home/wangcanliang/source/nagios-3.3.1.tar.gz  -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/nagios/
./configure --prefix=/webnew/nagios \
--with-httpd-conf=/webnew/httpd/conf/extra \
--localstatedir=/var/slog/nagios \
--with-gd-lib=/webnew/gd2/lib \
--with-gd-inc=/webnew/gd2/include

make all
make install
make install-init
make install-commandmode
make install-config
make install-webconf

#mv /webnew/httpd/conf/nagios.conf /webnew/httpd/conf/extra/


tar zxvf /home/wangcanliang/source/nagios-plugins-1.4.15.tar.gz -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/nagios-plugins-1.4.15/
./configure --prefix=/webnew/nagios/
make
make install

chkconfig --add nagios
chkconfig nagios on
/usr/local/nagios/bin/nagios -v /usr/local/nagios/etc/nagios.cfg
service nagios start

tar zxvf /home/wangcanliang/source/nload*.tar.gz -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/nload*/
./configure --prefix=/webnew/nload/
make
make install
如安装时提示下面的问题
configure: error: ncurses library or development files not found. ncurses is required for nload.
make: *** No targets specified and no makefile found. Stop.
make: *** No rule to make target `install'. Stop.
用 yum install -y ncurses-devel 即可解决