#welcome
cat << EOF
+--------------------------------------------------------------+
|         === Welcome to Centos System init ===                |
+--------------------------------------------------------------+
+----------------------Author:NetSeek--------------------------+
EOF

#disable ipv6
cat << EOF
+--------------------------------------------------------------+
|         === Welcome to Disable IPV6 ===                      |
+--------------------------------------------------------------+
EOF
echo "alias net-pf-10 off" >> /etc/modprobe.conf
echo "alias ipv6 off" >> /etc/modprobe.conf
/sbin/chkconfig --level 35 ip6tables off
echo "ipv6 is disabled!"

#disable selinux
sed -i '/SELINUX/s/enforcing/disabled/' /etc/selinux/config 
echo "selinux is disabled,you must reboot!"

#vim
sed -i "8 s/^/alias vi='vim'/" /root/.bashrc
echo 'syntax on' > /root/.vimrc

#zh_cn
sed -i -e 's/^LANG=.*/LANG="en"/'   /etc/sysconfig/i18n

#init_ssh
ssh_cf="/etc/ssh/sshd_config" 
sed -i -e '74 s/^/#/' -i -e '76 s/^/#/' $ssh_cf
sed -i "s/#UseDNS yes/UseDNS no/" $ssh_cf
#client
sed -i -e '44 s/^/#/' -i -e '48 s/^/#/' $ssh_cf
echo "ssh is init is ok.............."
#chkser
#tunoff services
#--------------------------------------------------------------------------------
cat << EOF
+--------------------------------------------------------------+
|         === Welcome to Tunoff services ===                   |
+--------------------------------------------------------------+
EOF
#---------------------------------------------------------------------------------
for i in `ls /etc/rc3.d/S*`
do
             CURSRV=`echo $i|cut -c 15-`

echo $CURSRV
case $CURSRV in
         crond | irqbalance | microcode_ctl | network | random | sendmail | sshd | syslog | local | mysqld )
     echo "Base services, Skip!"
     ;;
     *)
         echo "change $CURSRV to off"
         chkconfig --level 235 $CURSRV off
         service $CURSRV stop
     ;;
esac
done

