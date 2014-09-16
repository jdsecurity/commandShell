#!/bin/bash
##backup 00:00:00
week=`date +%u`
Date=`date +%Y-%m-%d`
year=`date +'%Y'`
month=`date +'%m'`
day=`date +'%d'`
bakpath=/var/bak/webbak
webpath=/var/htmlwww
wzbakup=/var/bak/webbak/wzbf
backup=$bakpath/$year/$month/$(date +'%d' -d "1 day ago")
web=(bbs jzsgbbs ganwan ghome ghucenternew jzsg games)
cd $webpath
for i in ${web[*]}
        do
        if [[ $week = 1 ]];then
                if [ ! -d $wzbakup ]; then
                        mkdir -p $wzbakup
                fi
                        cd $wzbakup
                        tar -g $bakpath/$i.txt -zPcf $PWD/$i$Date.tar.gz $webpath/$i
                        rm -rf $i$(date +%Y-%m-%d -d "7 days ago").tar.gz
                        rm -rf $backup/*

        else
                if [ ! -d $backup/$i ]; then
                        mkdir -p $backup/$i
                fi

                        tar -g $bakpath/$i.txt -zPcf $backup/$i/$i.tar.gz $webpath/$i
                        rm -rf $wzbakup/$i$(date +%Y-%m-%d -d "8 days ago").tar.gz

        fi
done
