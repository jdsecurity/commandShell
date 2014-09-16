#!/bin/bash
# This shell is used to deal with the log of nginx.

#/usr/local/awstats/tools/awstats_buildstaticpages.pl -update -config=www.moabc.net -lang=cn -dir=/var/htmlwww/nlog/ -awstatsprog=/usr/local/awstats/wwwroot/cgi-bin/awstats

#logs_root=("/var/log/nginx/" "/var/log/nginx/pnginx/")
year=`date '+%Y'`
month=`date '+%m'`
#cday=`date '+%d'`
day=`date '+%d'`
#day=$[ ${cday}-1 ]
#day=${cday}
#fileprefix=`date '+%s'`
log_path="/var/weblog/pnginx/${year}/${month}/${day}"

for log_file in `ls ${log_path}`;
do
    fweb_log=`echo ${log_file} | sed 's/_.*//g'`
    show_path="/var/htmlwww/nlog/${fweb_log}/${year}/${month}/${day}/"
    if [ ! -d ${show_path} ]; then
        mkdir -p ${show_path}
    fi
    /usr/local/awstats/wwwroot/cgi-bin/awstats.pl -update -config=${fweb_log}
    /usr/local/awstats/tools/awstats_buildstaticpages.pl -update -config=${fweb_log} -lang=cn -dir=${show_path} -awstatsprog=/usr/local/awstats/wwwroot/cgi-bin/awstats
    #log_web=`echo ${log_file} | sed 's/\..*//g'`
    echo ${fweb_log}
done

