#usermod -G bin,adm,lp,nagios daemon
#/webnew/httpd/bin/htpasswd -c /webnew/nagios/etc/htpasswd.users wangcanliang

文件名或目录名           用途
cgi.cfg                  控制CGI访问的配置文件
nagios.cfg               Nagios 主配置文件
resource.cfg             变量定义文件，又称为资源文件，在些文件中定义变量，以便由其他配置文件引用，如$USER1$
objects                  objects 是一个目录，在此目录下有很多配置文件模板，用于定义Nagios 对象
objects/commands.cfg     命令定义配置文件，其中定义的命令可以被其他配置文件引用
objects/contacts.cfg     定义联系人和联系人组的配置文件
objects/localhost.cfg    定义监控本地主机的配置文件
objects/printer.cfg      定义监控打印机的一个配置文件模板，默认没有启用此文件
objects/switch.cfg       定义监控路由器的一个配置文件模板，默认没有启用此文件
objects/templates.cfg    定义主机和服务的一个模板配置文件，可以在其他配置文件中引用
objects/timeperiods.cfg  定义Nagios 监控时间段的配置文件
objects/windows.cfg      监控Windows 主机的一个配置文件模板，默认没有启用此文件 
