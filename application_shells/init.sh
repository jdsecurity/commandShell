#!/bin/bash
# stop the service that isn't useful.

service portmap stop Linux的RPC服务,它响应RPC服务的请求和与请求的RPC服务建立连接
service nfslock stop  # 用于启动相应的RPC进程，允许NFS客户端在服务器上对文件加锁
service cups stop  # 打印服务
service sendmail stop  # 邮件服务