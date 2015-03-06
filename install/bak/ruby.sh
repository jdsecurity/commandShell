!#/bin/bash
# Install Zlib+freetype+jpeg+libpng+gd+libiconv+libmcrypt+mhash+mcrypt

curl -O http://www6.atomicorp.com/channels/atomic/centos/6/x86_64/RPMS/atomic-release-1.0-14.el6.art.noarch.rpm
rpm -Uvh atomic-release-1.0-14.el6.art.noarch.rpm
curl -L https://get.rvm.io | bash -s stable --ruby
yum list available 'ruby*'
source /usr/local/rvm/scripts/rvm
rvm install 1.9.3
rvm use 1.9.3
rvm rubygems latest 

rvm use 1.9.3
rvm rubygems latest --verify-downloads 1
cd /var/htmlwww/
git clone git://github.com/imathis/octopress.git octopress
cd octopress/
gem install bundler
rbenv rehash
bundle install
bundle show
rake install
