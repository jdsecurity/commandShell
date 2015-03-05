#!/bin/bash
####by liming 00:00
BAKWEB=/var/bak/web
DATE=`date +%Y-%m-%d`
tar zcvf ${BAKWEB}/18481com${DATE}.tar.gz /var/htmlwww/18481com
tar zcvf ${BAKWEB}/products${DATE}.tar.gz /var/htmlwww/products
#tar zcvf ${BAKWEB}/zf001net${DATE}.tar.gz --exclude=/var/htmlwww/zf001net/data/* /var/htmlwww/zf001net
