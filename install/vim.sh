cd /opt/sourcepackage/
wget ftp://ftp.vim.org/pub/vim/unix/vim-7.4.tar.bz2

yum install python-devel

tar jxvf /opt/sourcepackage/vim-7.4.tar.bz2 -C /opt/source
cd /opt/source/vim74/

./configure \
--with-features=huge \
--enable-rubyinterp \
--enable-pythoninterp \
--with-python-config-dir=/opt/soft/python/lib/python2.7/config/ \
--enable-cscope \
--enable-luainterp \
--enable-multibyte \
--prefix=/opt/soft/vim
#--enable-perlinterp \
#make distclean 

#--with-features=huge：支持最大特性
#--enable-rubyinterp：启用Vim对ruby编写的插件的支持
#--enable-pythoninterp：启用Vim对python编写的插件的支持
#--enable-luainterp：启用Vim对lua编写的插件的支持
#--enable-perlinterp：启用Vim对perl编写的插件的支持
#--enable-multibyte：多字节支持 可以在Vim中输入中文
#--enable-cscope：Vim对cscope支持
#--enable-gui=gtk2：gtk2支持,也可以使用gnome，表示生成gvim
#--with-python-config-dir=/usr/lib/python2.7/config-i386-linux-gnu/ 指定 python 路径
#--prefix=/usr：编译安装路径


make ; make install
ln -s /opt/soft/vim/bin/vim /usr/bin/vim

mkdir /var/slog/vim
cd /var/slog/vim
git clone https://github.com/wangcan/vimrc
./vimrc/install.sh

vi ~/.vimrc
cd ~
mkdir .vim/bundle -p
cd .vim/bundle/
git clone https://github.com/gmarik/Vundle.vim

# windows https://github.com/gmarik/Vundle.vim/wiki/Vundle-for-Windows
# install msysgit "Run Git from the Windows Command Prompt
# install Curl
mkdir /c/vim/vimfiles/bundle
cd /c/vim/vimfiles/bundle
git clone https://github.com/gmarik/Vundle.vim.git 
