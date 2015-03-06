svnadmin create //var/slog/svn/jarbao # 创建一个版本库
svnserve -d -r //var/slog/svn # 启动svn服务
killall svnserve # 停止svn服务

# vi //var/slog/svn/jarbao/conf/svnserve.conf
# vi //var/slog/svn/jarbao/conf/passwd
# vi //var/slog/svn/jarbao/conf/auth

cd /opt/sourcepackage
wget http://nodejs.org/dist/v0.10.30/node-v0.10.30.tar.gz
tar zxvf node-v0.10.30.tar.gz -C /opt/source
cd ../source/node-v0.10.30/
./configure
make
make install

npm install -g express-generator
npm install -g supervisor 
cd /var/htmlwww/
git clone https://github.com/wangcan/webExpress
cd webExpress
express missbao
cd missbao
supervisor ./bin/www &

cd /opt/sourcepackage
wget **mongodb**
tar zxvf mongodb* -C /opt/soft/mongodb

/opt/soft/mongodb/bin/mongod --dbpath=/var/slog/mongodb/data/ --logpath=/var/slog/mongodb/logs/mongodb.log --logappend & # 启动mongodb
killall mongod # 停止mongodb

/opt/soft/mongodb/bin/mongod --config /opt/soft/mongodb/etc/mongodb.conf &
ps -ef|grep mongo; kill -2 pid
