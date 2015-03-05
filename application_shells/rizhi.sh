#!/bin/bash
DATE=`date`
####################
#°´Ä´æ´ó¡ÅÁ
ps -e  -o "%C  : %p : %z : %a"|sort -k5 -nr|head -10 >> /home/rizhi/mem.txt
echo $DATE _______________________________________________________________________________________________________________________ >> /home/rizhi/mem.txt
#°´cpuÀÓÂ´Ӵó¡ÅÁ
ps -e  -o "%C  : %p : %z : %a"|sort  -nr |head -10 >> /home/rizhi/cpu.txt
echo $DATE _______________________________________________________________________________________________________________________ >> /home/rizhi/cpu.txt
###########ÍÂl½Óýtstat
netstat -an | grep -E '^(tcp)' | cut -c 68- | sort |uniq -c |sort -n |head -10 >> /home/rizhi/wangka.txt
echo $DATE _______________________________________________________________________________________________________________________ >> /home/rizhi/wangka.txt
#CPU¸ºÔ
cat /proc/loadavg | head -10 >> /home/rizhi/cpufz.txt
echo $DATE _______________________________________________________________________________________________________________________ >> /home/rizhi/cpufz.txt
#ping www.baidu.com
ping www.baidu.com |head -10 >> /home/rizhi/ping.txt
echo $DATE _______________________________________________________________________________________________________________________ >> /home/rizhi/ping.txt
