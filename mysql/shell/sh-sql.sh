#!/bin/bash

HOSTNAME="192.168.111.84" #数据库信息
PORT="3306"
USERNAME="root"
PASSWORD=""

DBNAME="test_db_test"  #数据库名称
TABLENAME="test_table_test"  #数据库中表的名称

#创建数据库
create_db_sql="create database IF NOT EXISTS ${DBNAME}"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} -e "${create_db_sql}"

#创建表
create_table_sql="create table IF NOT EXISTS ${TABLENAME} (  name varchar(20), id int(11) default 0 )"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${create_table_sql}"

#插入数据
insert_sql="insert into ${TABLENAME} values('billchen',2)"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${insert_sql}"
 
#查询
select_sql="select * from ${TABLENAME}"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${select_sql}"

#更新数据
update_sql="update ${TABLENAME} set id=3"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${update_sql}"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${select_sql}"

#删除数据
delete_sql="delete from ${TABLENAME}"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${delete_sql}"
mysql -h${HOSTNAME}  -P${PORT}  -u${USERNAME} -p${PASSWORD} ${DBNAME} -e "${select_sql}"
