#!/bin/bash
#php-fastcgi.php
fcgi_cf="/usr/local/php-fcgi/etc/php.ini"
sed -i '205 s#;open_basedir =#open_basedir = /data/www/wwwroot:/tmp#g' $fcgi_cf
sed -i '210 s#disable_functions =#disable_functions = phpinfo,passthru,exec,system,chroot,scandir,chgrp,chown,shell_exec,proc_open,proc_get_status,ini_alter,ini_alter,ini_restore,dl,pfsockopen,openlog,syslog,readlink,symlink,popepassthru,stream_socket_server#g' $fcgi_cf
sed -i '/expose_php/s/On/Off/' $fcgi_cf
sed -i '/display_errors/s/On/Off/' $fcgi_cf
sed -i 's#extension_dir = "./"#extension_dir = "/usr/local/php-fcgi/lib/php/extensions/no-debug-non-zts-20060613/"\nextension = "memcache.so"\nextension = "pdo_mysql.so"\n#' $fcgi_cf
sed -i 's#output_buffering = Off#output_buffering = On#' $fcgi_cf
