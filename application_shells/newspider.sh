#!/bin/bash
# test operation!

spiderActions=('' 'glist' 'slist' 'gpage' 'spage' 'sfile')
spiderAction=${spiderActions[$1]}
if [[ ${spiderAction} != '' ]]; then
        echo ${spiderAction};
        spiderNum=$2;
        if [[ $spiderNum -lt 1 ]] || [[ $spiderNum -gt 200 ]]; then
                spiderNum=50;
        fi
        currentNum=1;
        for (( i=1; i<=$spiderNum; i=i+1 ))
        do
		spiderUrl="117.79.238.170:8088/newspider/public/admin/spider/${spiderAction}/extparam/minfo/jobid/${i}"
                echo ${spiderUrl};
                `lynx ${spiderUrl} > /tmp/spider.txt &`
        done
fi
