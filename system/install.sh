#!/bin/bash  
#author dl528888
#blog http://dl528888.blog.51cto.com

LANG=C 
installhere="/data/software"  #脚本与软件包存放的地方
nginx_dir="/usr/local/nginx"  #nginx的安装目录
php_dir="/usr/local/php"  #php的安装目录
mysql_dir="/usr/local/mysql"  #mysql的安装目录
mysql_datadir="/data/mysql/data" #mysql的数据存放目录
mysql_logdir="/data/mysql"  #mysql的日志目录
mysql_passwd="admin"  #mysql的登陆密码

# Check if user is root   #脚本需要在root用户下运行，所以先进行用户监测
if [ $(id -u) != "0" ]; then  
	echo "Error: You must be root to run this script, please use root to install soft"  
	exit 1  
fi

#Disable SeLinux   #关闭selinux
if [ -s /etc/selinux/config ]; then  
	sed -i 's/SELINUX=enforcing/SELINUX=disabled/g' /etc/selinux/config  
fi 

if [ ! -d "$installhere" ];then  #如果脚本存放的目录不存在，就自动的创建
	mkdir -p $installhere  
fi
  
if [ ! -d "$installhere/soft" ];then  #如果脚本不在那个存放的目录里，则复制过去
	cp -a soft $installhere  
fi

case $1 in  
install_yum)  
install_yum  
;;  
init)  
start_time  
init  
end_time  
;;  
install_mysql)  
start_time  
install_mysql  
end_time  
;;  
install_nginx)  
start_time  
install_nginx  
end_time  
;;  
install_php)  
start_time  
install_php  
end_time  
;;  
install_lnmp)  
start_time  
init  
install_mysql  
install_nginx  
install_php  
end_time  
;;  
install_check)  
start_time  
install_check  
end_time  
;;  
*)  
echo "Usage:`basename $0` {install_yum|init|install_mysql|install_nginx|install_php|install_lnmp|install_check}"  
;;  
esac  

#set up runtime   #进行运行时间的统计
function start_time()  
{  
	start_time="$(date +%s)" 
	echo "$(date) Start install!"  
	echo "$start_time" > /tmp/Install_lnmp_runtime  
}

function end_time()  
{  
	end_time="$(date +%s)" 
	total_s=$(($end_time - $start_time))  
	total_m=$(($total_s / 60))  
	if [ $total_s -lt 60 ]; then  
		time_en="${total_s} Seconds" 
	else  
		time_en="${total_m} Minutes" 
	fi  
	echo "$(date) Finish install!"  
	echo "Install_lnmp.sh runtime: ${time_en} "> /tmp/Install_lnmp_runtime  
	echo "Total runtime: ${time_en}"  
}

#if yum fail,please use install_yum to solve.  如果yum不可用，可以使用此模块来进行安装yum
function install_yum()  
{  
	wget http://packages.sw.be/rpmforge-release/rpmforge-release-0.5.1-1.el5.rf.i386.rpm  
	wget http://dag.wieers.com/rpm/packages/RPM-GPG-KEY.dag.txt  
	rpm -Uvh rpmforge-release-0.5.1-1.el5.rf.i386.rpm  
	rpm --import RPM-GPG-KEY.dag.txt  
	yum -y install yum-fastestmirror yum-presto  
}

#init set up Library 安装lnmp需要的库
function init()  
{
	yum -y install yum-fastestmirror yum-presto  
	yum -y install gcc gcc-c++ autoconf libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glibc glibc-devel glib2 glib2-devel bzip2 bzip2-devel ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel krb5-devel libidn libidn-devel openssl openssl-devel nss_ldap openldap openldap-devel  openldap-clients openldap-servers libxslt-devel libevent-devel ntp  libtool-ltdl bison libtool vim-enhanced  
}

#install mysql  安装mysql的模块
function install_mysql()  
{  
	cd $installhere/soft/mysql/  
	useradd -M -s /sbin/nologin mysql  
	mkdir -p $mysql_datadir;  
	chown mysql.mysql -R $mysql_datadir  
	tar xzf cmake-2.8.4.tar.gz  
	cd cmake-2.8.4  
	./configure  
	make &&  make install  
	cd ..  
	tar zxf mysql-5.5.10.tar.gz  
	cd mysql-5.5.10  
	cmake . -DCMAKE_INSTALL_PREFIX=$mysql_dir/ \  
		-DMYSQL_DATADIR=$mysql_datadir \  
		-DMYSQL_UNIX_ADDR=$mysql_logdir/mysqld.sock \  
		-DWITH_INNOBASE_STORAGE_ENGINE=1 \  
		-DENABLED_LOCAL_INFILE=1 \  
		-DMYSQL_TCP_PORT=3306 \  
		-DCMAKE_THREAD_PREFER_PTHREAD=1 \  
		-DEXTRA_CHARSETS=all \  
		-DDEFAULT_CHARSET=utf8 \  
		-DDEFAULT_COLLATION=utf8_general_ci \  
		-DMYSQL_UNIX_ADDR=$mysql_logdir/mysql.sock \  
		-DWITH_DEBUG=0 
	make && make install  
	rm -rf /etc/my.cnf  
	rm -rf /etc/init.d/mysqld  
	mkdir $mysql_logdir/relaylog  
	mkdir $mysql_logdir/binlog  
	cp $installhere/soft/mysql/my.cnf /etc/my.cnf  
	cp support-files/mysql.server /etc/init.d/mysqld  
	chmod 755 /etc/init.d/mysqld  
	chkconfig --add mysqld  
	chkconfig mysqld on  
	chown mysql.mysql -R $mysql_logdir  
	chown mysql.mysql -R $mysql_datadir  
	$mysql_dir/scripts/mysql_install_db --user=mysql --basedir=$mysql_dir --datadir=$mysql_datadir  
	/sbin/service mysqld start  
	echo 'export PATH=$PATH:'$mysql_dir'/bin' >> /etc/profile  
	 
	$mysql_dir/bin/mysql -e "grant all privileges on *.* to root@'%' identified by '$mysql_passwd' with grant option;"  
	$mysql_dir/bin/mysql -e "flush privileges;"  
	$mysql_dir/bin/mysql -e "delete from mysql.user where password='';"  
	source /etc/profile  
	/sbin/service mysqld restart  
	echo "mysql install success!"  
}

#install php  安装php的模块
function install_php()  
{  
	cd $installhere/soft/php  
	tar xzf libiconv-1.13.1.tar.gz  
	cd libiconv-1.13.1  
	./configure --prefix=/usr/local  
	make && make install  

	cd ../  
	tar xzf libmcrypt-2.5.8.tar.gz  
	cd libmcrypt-2.5.8  
	./configure  
	make && make install  
	/sbin/ldconfig  
	cd libltdl/  
	./configure --enable-ltdl-install  
	make && make install  

	cd ../../  
	tar xzf mhash-0.9.9.9.tar.gz  
	cd mhash-0.9.9.9  
	./configure  
	make && make install  

	cd ../  
	if [ -e "/lib64" ];then  
		ln -s /usr/local/lib/libmcrypt.la /usr/lib64/libmcrypt.la  
		ln -s /usr/local/lib/libmcrypt.so /usr/lib64/libmcrypt.so  
		ln -s /usr/local/lib/libmcrypt.so.4 /usr/lib64/libmcrypt.so.4  
		ln -s /usr/local/lib/libmcrypt.so.4.4.8 /usr/lib64/libmcrypt.so.4.4.8  
		ln -s /usr/local/lib/libmhash.a /usr/lib64/libmhash.a  
		ln -s /usr/local/lib/libmhash.la /usr/lib64/libmhash.la  
		ln -s /usr/local/lib/libmhash.so /usr/lib64/libmhash.so  
		ln -s /usr/local/lib/libmhash.so.2 /usr/lib64/libmhash.so.2  
		ln -s /usr/local/lib/libmhash.so.2.0.1 /usr/lib64/libmhash.so.2.0.1  
		ln -s /usr/local/bin/libmcrypt-config /usr/bin/libmcrypt-config  
		ln -s /usr/local/mysql/lib/libmysqlclient.so.18 /lib64/libmysqlclient.so.18  
	else  
		ln -s /usr/local/lib/libmcrypt.la /usr/lib/libmcrypt.la  
		ln -s /usr/local/lib/libmcrypt.so /usr/lib/libmcrypt.so  
		ln -s /usr/local/lib/libmcrypt.so.4 /usr/lib/libmcrypt.so.4  
		ln -s /usr/local/lib/libmcrypt.so.4.4.8 /usr/lib/libmcrypt.so.4.4.8  
		ln -s /usr/local/lib/libmhash.a /usr/lib/libmhash.a  
		ln -s /usr/local/lib/libmhash.la /usr/lib/libmhash.la  
		ln -s /usr/local/lib/libmhash.so /usr/lib/libmhash.so  
		ln -s /usr/local/lib/libmhash.so.2 /usr/lib/libmhash.so.2  
		ln -s /usr/local/lib/libmhash.so.2.0.1 /usr/lib/libmhash.so.2.0.1  
		ln -s /usr/local/bin/libmcrypt-config /usr/bin/libmcrypt-config  
		ln -s /usr/local/mysql/lib/libmysqlclient.so.18 /lib/libmysqlclient.so.18  
	fi  
 
	tar xzf mcrypt-2.6.8.tar.gz  
	cd mcrypt-2.6.8  
	/sbin/ldconfig  
	./configure  
	make && make install
	
cd ../  
ln -s /usr/local/mysql/lib/libmysqlclient.so.18 /usr/lib  
if [ `getconf WORD_BIT` = '32' ] && [ `getconf LONG_BIT` = '64' ] ; then  
		ln -s /usr/lib64/libpng.* /usr/lib/  
		ln -s /usr/lib64/libjpeg.* /usr/lib/  
fi  
if [ ! `grep -l "/lib"    '/etc/ld.so.conf'` ]; then  
	echo "/lib" >> /etc/ld.so.conf  
fi  
 
if [ ! `grep -l '/usr/lib'    '/etc/ld.so.conf'` ]; then  
	echo "/usr/lib" >> /etc/ld.so.conf  
fi  
 
if [ -d "/usr/lib64" ] && [ ! `grep -l '/usr/lib64'    '/etc/ld.so.conf'` ]; then  
	echo "/usr/lib64" >> /etc/ld.so.conf  
fi  
 
if [ ! `grep -l '/usr/local/lib'    '/etc/ld.so.conf'` ]; then  
	echo "/usr/local/lib" >> /etc/ld.so.conf  
fi  
/sbin/ldconfig  
tar xzf php-5.3.10.tar.gz  
useradd -M -s /sbin/nologin www  
cd php-5.3.10  
./configure  --prefix=$php_dir --with-mysql=$mysql_dir  --with-mysqli=$mysql_dir/bin/mysql_config --with-iconv-dir=/usr/local --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath --enable-safe-mode --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl --with-curlwrappers --enable-mbregex --enable-fpm --enable-mbstring --with-mcrypt --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-pcntl --enable-sockets --with-ldap --with-ldap-sasl --with-xmlrpc --enable-ftp --enable-zip --enable-soap --disable-debug  
make ZEND_EXTRA_LIBS='-liconv' 
make install  
cp php.ini-production $php_dir/lib/php.ini  
cd ../  
tar xzf memcache-2.2.5.tgz  
cd memcache-2.2.5  
$php_dir/bin/phpize  
./configure --with-php-config=$php_dir/bin/php-config  
make && make install  
cd ../  
tar xjf eaccelerator-0.9.6.1.tar.bz2  
cd eaccelerator-0.9.6.1  
/usr/local/php/bin/phpize  
./configure --enable-eaccelerator=shared --with-php-config=$php_dir/bin/php-config  
make && make install  
cd ../  
tar xzf PDO_MYSQL-1.0.2.tgz  
cd PDO_MYSQL-1.0.2  
$php_dir/bin/phpize  
./configure --with-php-config=$php_dir/bin/php-config --with-pdo-mysql=$mysql_dir  
make && make install  
cd ../  
tar xzf ImageMagick-6.6.7-10.tar.gz  
cd ImageMagick-6.6.7-10  
./configure  
make && make install  
cd ../  
tar xzf imagick-2.3.0.tgz  
cd imagick-2.3.0  
/usr/local/php/bin/phpize  
./configure --with-php-config=$php_dir/bin/php-config  
make && make install  
cd ../  
#Modiry php.ini  
mkdir /tmp/eaccelerator  
/bin/chown -R www.www /tmp/eaccelerator/  
sed -i '808a extension_dir = "'$php_dir'/lib/php/extensions/no-debug-non-zts-20090626/"' $php_dir/lib/php.ini  
sed -i '809a extension = "memcache.so"' $php_dir/lib/php.ini  
sed -i '810a extension = "pdo_mysql.so"' $php_dir/lib/php.ini  
sed -i '811a extension = "imagick.so"' $php_dir/lib/php.ini  
sed -i '134a output_buffering = On' $php_dir/lib/php.ini  
sed -i '847a cgi.fix_pathinfo=0' $php_dir/lib/php.ini  
sed -i 's@;date.timezone =@date.timezone = Asia/Shanghai@g' $php_dir/lib/php.ini  
echo '[eaccelerator]  
zend_extension="'$php_dir'/lib/php/extensions/no-debug-non-zts-20090626/eaccelerator.so" 
eaccelerator.shm_size="64" 
eaccelerator.cache_dir="/tmp/eaccelerator" 
eaccelerator.enable="1" 
eaccelerator.optimizer="1" 
eaccelerator.check_mtime="1" 
eaccelerator.debug="0" 
eaccelerator.filter="" 
eaccelerator.shm_max="0" 
eaccelerator.shm_ttl="0" 
eaccelerator.shm_prune_period="0" 
eaccelerator.shm_only="0" 
eaccelerator.compress="0" 
eaccelerator.compress_level="9" 
eaccelerator.keys = "disk_only" 
eaccelerator.sessions = "disk_only" 
eaccelerator.content = "disk_only"' >> $php_dir/lib/php.ini  
 
echo ';;;;;;;;;;;;;;;;;;;;;  
; FPM Configuration ;  
;;;;;;;;;;;;;;;;;;;;;  
 
;;;;;;;;;;;;;;;;;;  
; Global Options ;  
;;;;;;;;;;;;;;;;;;  
 
[global]  
pid = run/php-fpm.pid  
error_log = log/php-fpm.log  
log_level = notice 
 
emergency_restart_threshold = 30 
emergency_restart_interval = 1m 
process_control_timeout = 5s 
daemonize = yes 
 
;;;;;;;;;;;;;;;;;;;;  
; Pool Definitions ;  
;;;;;;;;;;;;;;;;;;;;  
 
[www]  
 
listen = 127.0.0.1:9000  
listen.backlog = -1  
listen.allowed_clients = 127.0.0.1  
listen.owner = www 
listen.group = www 
listen.mode = 0666 
user = www 
group = www 
 
pm = dynamic 
pm.max_children = 32 
pm.start_servers = 4 
pm.min_spare_servers = 4 
pm.max_spare_servers = 16 
pm.max_requests = 512 
 
request_terminate_timeout = 0 
request_slowlog_timeout = 0 
slowlog = log/$pool.log.slow  
rlimit_files = 51200 
rlimit_core = 0 
 
catch_workers_output = yes 
env[HOSTNAME] = $HOSTNAME  
env[PATH] = /usr/local/bin:/usr/bin:/bin  
env[TMP] = /tmp  
env[TMPDIR] = /tmp  
env[TEMP] = /tmp ' >> $php_dir/etc/php-fpm.conf  
echo "$php_dir/sbin/php-fpm" >> /etc/rc.local  
$php_dir/sbin/php-fpm  
echo '<? 
phpinfo();  
?>' >$nginx_dir/html/phpinfo.php  
echo "php install success!"  
}

#install nginx  安装nginx的模块
function install_nginx()  
{  
	cd $installhere/soft/nginx  
	tar xzf pcre-8.12.tar.gz  
	cd pcre-8.12  
	./configure  
	make && make install
	
	cd ../  
	tar xzf ngx_cache_purge-1.3.tar.gz  
	tar xzf nginx-1.0.12.tar.gz  
	cd nginx-1.0.12  
	#Modify nginx Edition information  
	sed -i 's@#define NGINX_VERSION.*$@#define NGINX_VERSION      "1.0"@g' src/core/nginx.h  
	sed -i 's@#define NGINX_VER.*NGINX_VERSION$@#define NGINX_VER          "YWS/" NGINX_VERSION@g' src/core/nginx.h  
	./configure --prefix=$nginx_dir --user=www --group=www --with-http_stub_status_module --with-http_ssl_module --add-module=../ngx_cache_purge-1.3  
	make && make install  
	cd $installhere/soft/nginx/  
	cp nginx.sh /etc/init.d/nginx  
	chmod 755 /etc/init.d/nginx  
	chkconfig --add nginx  
	chkconfig nginx on  
	rm -rf $nginx_dir/conf/nginx.conf  
	cp nginx.conf $nginx_dir/conf/nginx.conf  
	echo "ulimit -SHn 65535" >>/etc/rc.local  
	echo "$nginx_dir/sbin/nginx" >> /etc/rc.local  
	echo '#ADD  
	net.ipv4.tcp_max_syn_backlog = 65536 
	net.core.netdev_max_backlog =  32768 
	net.core.somaxconn = 32768 
	 
	net.core.wmem_default = 8388608 
	net.core.rmem_default = 8388608 
	net.core.rmem_max = 16777216 
	net.core.wmem_max = 16777216 
	 
	net.ipv4.tcp_timestamps = 0 
	net.ipv4.tcp_synack_retries = 2 
	net.ipv4.tcp_syn_retries = 2 
	 
	net.ipv4.tcp_tw_recycle = 1 
	#net.ipv4.tcp_tw_len = 1 
	net.ipv4.tcp_tw_reuse = 1 
	 
	net.ipv4.tcp_mem = 94500000 915000000 927000000  
	net.ipv4.tcp_max_orphans = 3276800 
	 
	#net.ipv4.tcp_fin_timeout = 30 
	#net.ipv4.tcp_keepalive_time = 120 
	net.ipv4.ip_local_port_range = 1024  65535' >>/etc/sysctl.conf  
	/sbin/sysctl -p  
	echo '#!/bin/bash  
	# This script run at 00:00  
	 
	# The Nginx logs path  
	logs_path="'$nginx_dir'/logs/" 
	mkdir -p ${logs_path}$(date -d "yesterday" +"%Y")/$(date -d "yesterday" +"%m")/  
	mv ${logs_path}access.log ${logs_path}$(date -d "yesterday" +"%Y")/$(date -d "yesterday" +"%m")/access_$(date -d "yesterday" +"%Y%m%d").log  
	kill -USR1 `cat '$nginx_dir'/nginx.pid` '>>$nginx_dir/sbin/cut_nginx_log.sh  
	chmod 755 $nginx_dir/sbin/cut_nginx_log.sh  
	echo "00 00 * * * /bin/bash  $nginx_dir/sbin/cut_nginx_log.sh" >> /var/spool/cron/root  
	$nginx_dir/sbin/nginx  
	echo "nginx install success!"  
}

#check install  检测模块
function install_check()  
{  
	echo "========================== Check install ================================"  
	clear  
	if [ -s $nginx_dir ]; then  
	  echo "$nginx_dir [found]"  
	else  
	  echo "Error: $nginx_dir not found!!!"  
	fi  
	 
	if [ -s $php_dir ]; then  
	  echo "$php_dir   [found]"  
	else  
	  echo "Error: $php_dir not found!!!"  
	fi  
	 
	if [ -s $mysql_dir ]; then  
	  echo "$mysql_dir [found]"  
	else  
	  echo "Error: $mysql_dir not found!!!"  
	fi  
	 
	echo "========================== Check install ================================"  
	if [ -s $nginx_dir ] && [ -s $php_dir ] && [ -s $mysql_dir ]; then   
		echo "LNMP  is completed! "  
		echo "default mysql root password:$mysql_passwd"  
		echo "The path of some dirs:"  
		echo "mysql dir:      $mysql_dir"  
		echo "php dir:        $php_dir"  
		echo "php info:         $nginx_dir/html/phpinfo.php"  
		echo "nginx dir:      $nginx_dir"  
		echo "web dir :       $nginx_dir/html"  
		echo "=========================================================================="  
	else  
		echo "Sorry,Failed to install LNMP!"  
		echo "Please check errors and logs."  
	fi
}
