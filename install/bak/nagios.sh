!#/bin/bash
# Install Subversion+Nagios

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
