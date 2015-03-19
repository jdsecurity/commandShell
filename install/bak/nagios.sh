!#/bin/bash
# Install Subversion+Nagios

#yum install -y gcc glibc glibc-common gd gd-devel xinetd openssl-devel 
#sestatus -v | getenforce; vim /etc/selinux/config # SELINUX=enforcing->disabled

groupadd nagios
useradd -g nagios -d /opt/soft/nagios -s /bin/false nagios
chmod 755 /opt/soft/nagios
usermod -a -G nagios daemon

cd /opt/sourcepackage/
wget http://prdownloads.sourceforge.net/sourceforge/nagios/nagios-4.0.8.tar.gz
wget http://nagios-plugins.org/download/nagios-plugins-2.0.3.tar.gz
tar zxvf /opt/sourcepackage/nagios-*  -C /opt/source
cd /opt/source/nagios-*
./configure --prefix=/opt/soft/nagios \
--with-command-group=nagios \
--with-httpd-conf=/opt/soft/httpd/conf/extra \
--localstatedir=/var/slog/nagios

make all
make install
make install-init
make install-commandmode
make install-config
make install-webconf

#mv /opt/soft/httpd/conf/nagios.conf /opt/soft/httpd/conf/extra/

tar zxvf /opt/sourcepackage/nagios-plugins-* -C /opt/source/
cd /opt/source/nagios-plugins-*/
./configure --prefix=/opt/soft/nagios/ \
--with-nagios-user=nagios \
--with-nagios-group=nagios  \
--with-mysql 
make && make install

chkconfig --add nagios
chkconfig nagios on
/usr/local/nagios/bin/nagios -v /usr/local/nagios/etc/nagios.cfg
service nagios start

tar zxvf /home/wangcanliang/source/nload*.tar.gz -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/nload*/
./configure --prefix=/opt/soft/nload/
make
make install
如安装时提示下面的问题
configure: error: ncurses library or development files not found. ncurses is required for nload.
make: *** No targets specified and no makefile found. Stop.
make: *** No rule to make target `install'. Stop.
用 yum install -y ncurses-devel 即可解决
