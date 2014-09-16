wget http://www.skycn.com/soft/3455.html
tar zxvf /home/wangcanliang/source/rarlinux-4* -C /home/wangcanliang/spath/
cd /home/wangcanliang/spath/rar*
make install

rar x *.rar */
#cp rar/rar_static /usr/local/bin/rar