!#/bin/bash
# config the linux base config and base soft

# CentOS 6.2 Minimal Install
# vi /etc/sysconfit/network-scripts/ifcfg-eth0
# DEVICE="eth0"
# HWADDR="No change"
# NM_CONTROLLED="no"
# ONBOOT="yes"
# NETMASK="255.255.255.0"
# IPADDR="192.168.1.121"
# GATEWAY="192.168.1.1"
# TYPE="Ethernet"
echo 'nameserver 192.168.1.1' > /etc/resolv.conf
service network restart

#service portmap stop  # Linux的RPC服务,它响应RPC服务的请求和与请求的RPC服务建立连接
#service nfslock stop  # 用于启动相应的RPC进程，允许NFS客户端在服务器上对文件加锁
#service cups stop     # 打印服务
#service sendmail stop # 邮件服务
#service qpidd stop
#service postfix stop  # 邮件服务

adduser wangcanliang
mkdir /opt/{source,sourcepackage,soft}
mkdir /var/slog/{nagios,nginx,httpd,mysql,php,svn,openldap} -p

rpm -ivh http://mirrors.sohu.com/fedora-epel/6/x86_64/epel-release-6-7.noarch.rpm
rpm --import /etc/pki/rpm-gpg/RPM-GPG-KEY-EPEL-6
yum -y install yum-priorities
yum update

yum -y install gcc gcc-c++ make automake autoconf kernel-devel ncurses-devel \
    libxml2-devel openssl-devel curl-devel libjpeg-devel libpng-devel pcre-devel \
    libtool-libs freetype-devel gd zlib-devel file bison patch mlocate \
    flex diffutils readline-devel glibc-devel glib2-devel bzip2-devel gettext-devel libcap-devel libmcrypt-devel

yum install wget

cd /opt/source/
wget http://github.com/downloads/rvoicilas/inotify-tools/inotify-tools-3.14.tar.gz
tar zxvf /opt/source/inotify-tools* -C /opt/sourcepackage/
cd /opt/sourcepackage/inotify-tools*
./configure --prefix=/usr && make && make install
