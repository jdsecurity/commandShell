/usr/sbin/groupadd www
/usr/sbin/useradd -g www www
mkdir -p /data/www/wwwroot
chmod +w /data/www/wwwroot
chown www:www /data/www/wwwroot -R 

