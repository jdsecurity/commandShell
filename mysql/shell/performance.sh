#!/bin/bash

# 系统mysql的进程数
ps -ef | grep "mysql" | grep -v "grep" | wc –l

# Slave_running 如果系统有一个从复制服务器，这个值指明了从服务器的健康度
mysql > show status like 'Slave_running';

# Threads_connected 当前客户端已连接的数量。这个值会少于预设的值，但你也能监视到这个值较大，这可保证客户端是处在活跃状态。
mysql > show status like 'Threads_connected';

# Threads_running 如果数据库超负荷了，你将会得到一个正在（查询的语句持续）增长的数值。这个值也可以少于预先设定的值。这个值在很短的时间内超过限定值是没问题的。当Threads_running值超过预设值时并且该值在5秒内没有回落时， 要同时监视其他的一些值。
mysql > show status like 'Threads_running';

# Aborted_clients 客户端被异常中断的数值，即连接到mysql服务器的客户端没有正常地断开或关闭。对于一些应用程序是没有影响的，但对于另一些应用程序可能你要跟踪该值，因为异常中断连接可能表明了一些应用程序有问题。
mysql > show status like 'Aborted_clients';

# Questions 每秒钟获得的查询数量，也可以是全部查询的数量，根据你输入不同的命令会得到你想要的不同的值。
mysql> show status like 'Questions';

# Handler_* 如果你想监视底层（low-level）数据库负载，这些值是值得去跟踪的。 如果Handler_read_rnd_next值相对于你认为是正常值相差悬殊，可能会告诉你需要优化或索引出问题了。Handler_rollback表明事务被回滚的查询数量。你可能想调查一下原因。
mysql> show status like 'Handler_%';

# Opened_tables 表缓存没有命中的数量。如果该值很大，你可能需要增加table_cache的数值。典型地，你可能想要这个值每秒打开的表数量少于1或2。
mysql> show status like 'Opened_tables';

# Select_full_join 没有主键（key）联合（Join）的执行。该值可能是零。这是捕获开发错误的好方法，因为一些这样的查询可能降低系统的性能。
mysql> show status like 'Select_full_join';

# Select_scan 执行全表搜索查询的数量。在某些情况下是没问题的，但占总查询数量该比值应该是常量（即Select_scan/总查询数量商应该是常数）。如果你发现该值持续增长，说明需要优化，缺乏必要的索引或其他问题。
mysql> show status like 'Select_scan';

# Slow_queries 超过该值（--long-query-time）的查询数量，或没有使用索引查询数量。对于全部查询会有小的冲突。如果该值增长，表明系统有性能问题。
mysql> show status like 'Slow_queries';

# Threads_created 该值应该是低的。较高的值可能意味着你需要增加thread_cache的数值，或你遇到了持续增加的连接，表明了潜在的问题。
mysql> show status like 'Threads_created';

# 客户端连接进程数 你可以通过使用其他的统计信息得到已连接线程数量和正在运行线程的数量，检查正在运行的查询花了多长时间是一个好主意。如果有一些长时间的查询，管理员可以被通知。你可能也想了解多少个查询是在"Locked"的状态—---该值作为正在运行的查询不被计算在内而是作为非活跃的。一个用户正在等待一个数据库响应。
shell> mysqladmin processlist
mysql> show processlist;

# innodb状态 该语句产生很多信息，从中你可以得到你感兴趣的。首先你要检查的就是“从最近的XX秒计算出来的每秒的平均负载”。
# (1)Pending normal aio reads: 该值是innodb io请求查询的大小（size）。如果该值大到超过了10—20，你可能有一些瓶颈。
# (2)reads/s, avg bytes/read, writes/s, fsyncs/s:这些值是io统计。对于reads/writes大值意味着io子系统正在被装载。适当的值取决于你系统的配置。
# (3)Buffer pool hit rate:这个命中率非常依赖于你的应用程序。当你觉得有问题时请检查你的命中率
# (4)inserts/s, updates/s, deletes/s, reads/s:有一些Innodb的底层操作。你可以用这些值检查你的负载情况查看是否是期待的数值范围。
mysql> show innodb status;

# 主机性能状态
shell> uptime

# CPU使用率
shell> top
shell> vmstat

# 磁盘IO
shell> vmstat
shell> iostat

# swap进出量(内存)
shell> free

# MySQL错误日志 在服务器正常完成初始化后，什么都不会写到错误日志中，因此任何在该日志中的信息都要引起管理员的注意。

# InnoDB表空间信息 InnoDB仅有的危险情况就是表空间填满----日志不会填满。检查的最好方式就是
mysql > show table status;你可以用任何InnoDB表来监视InnoDB表的剩余空间。

# QPS每秒Query量 QPS = Questions(or Queries) / seconds
mysql > show /* global */ status like 'Question';

# TPS(每秒事务量) TPS = (Com_commit + Com_rollback) / seconds
mysql > show status like 'Com_commit';
mysql > show status like 'Com_rollback';

# key Buffer 命中率 key_buffer_read_hits = (1-key_reads / key_read_requests) * 100% key_buffer_write_hits = (1-key_writes / key_write_requests) * 100%
mysql> show status like 'Key%';

# InnoDB Buffer命中率 Innodb_buffer_read_hits = (1 - innodb_buffer_pool_reads / innodb_buffer_pool_read_requests) * 100%
mysql> show status like 'innodb_buffer_pool_read%';

# Query Cache命中率 Query_cache_hits = (Qcahce_hits / (Qcache_hits + Qcache_inserts )) * 100%;
mysql> show status like 'Qcache%';

# Table Cache状态量
mysql> show status like 'open%';

# Thread Cache 命中率 Thread_cache_hits = (1 - Threads_created / connections ) * 100%
mysql> show status like 'Thread%';
mysql> show status like 'Connections';

# 锁定状态
mysql> show status like '%lock%';

# 复制延时量
mysql > show slave status

# Tmp Table状况(临时表状况)
mysql > show status like 'Create_tmp%';

# Binlog Cache使用状况
mysql > show status like 'Binlog_cache%';

# Innodb_log_waits量
mysql > show status like 'innodb_log_waits';

