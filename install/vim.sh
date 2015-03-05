cd /opt/sourcepackage/
wget ftp://ftp.vim.org/pub/vim/unix/vim-7.4.tar.bz2
tar jxvf vim-7.4.tar.bz2 -C ../source
cd ../source/vim74/
./configure --prefix=/opt/soft/vim --enable-multibyte
make ; make install
ln -s /opt/soft/vim/bin/vim /bin/vim
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
