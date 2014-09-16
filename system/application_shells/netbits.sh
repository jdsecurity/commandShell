#!/bin/bash

echo -n "Please input your netcard's interface:"
read eth

echo "The netcard of you wanting to watch is "${eth}
echo -n "Please input the time of you will waist(second):"
read sec

echo -n "You will get the avarage stream of "${sec}" seconds!" 

infirst=$(awk '/'${eth}'/{print $1}' /proc/net/dev | sed 's/'${eth}'://')
outfirst=$(awk '/'$eth'/{print $10}' /proc/net/dev)
sumfirst=$((${infirst}+${outfirst}))

sleep $sec"s"
inend=$(awk '/'${eth}'/{print $1}' /proc/net/dev | sed 's/'${eth}'://')
outend=$(awk '/'${eth}'/{print $10}' /proc/net/dev)
sumend=$((${inend}+${outend}))
sum=$((${sumend}-${sumfirst}))

echo $sec" second tatol stream is :"$sum"bytes"
aver=$((${sum}/${sec}))
echo "avaerage stream is :"$aver"bytes/sec"
