yum install libtidy libtidy-devel libxslt libxslt-devel

cd /opt/sourcepackage/
wget http://ftp.gnu.org/gnu/parallel/parallel-20150222.tar.bz2
tar jxvf parallel-20150222.tar.bz2 -C /opt/source
cd ../source/parallel-20150222/
./configure 
make && make install
