#!/bin/bash

# Rename filename
deletefpath () {
#        echo $1
        for fpath in `ls $1`
        do
                fpathname=$1${fpath}
                if [ -f ${fpathname} ]; then
                        rm -f ${fpathname}
#                       echo file${fpath}
                else
                        deletefpath ${fpathname}/
#                       echo path${fpath}
               fi
        done
}

deletepsvn () {
        for fpath in `ls -a $1`
        do
                fpathname=$1${fpath}
                if [ -d ${fpathname} ]; then
                        if [ ${fpath} == '.svn' ]; then
                                rm -rf ${fpathname}
                        else
                                if [ ${fpath} != '.' ] && [ ${fpath} != '..' ]; then
                                        deletepsvn ${fpathname}/
                                fi
                        fi
                fi
        done
}

rootpath="/var/bak/"
rpath="/var/bak/sgh/"
codepath="${rpath}codes/"

#cdate=`date +%Y-%m-%d`
cdate='2010-12-06'
wcodes=(games ghome)
export LANG=zh_CN.UTF-8

for wcode in "${wcodes[@]}"
do
	svnpath="${rpath}${wcode}/"
	tgzpath="${rootpath}${wcode}/"
	basefile="${wcode}${cdate}.tgz"

	bakfile=${tgzpath}${basefile}
	mcomments=`expr substr "${bakfile}" 21 10`
	infospath="${rpath}${wcode}infos/${mcomments}"

        cd ${codepath}
	rm -rf ${codepath}*

	tar zxvf ${bakfile} > ${infospath}_tar.txt
	scode="${codepath}var/htmlwww/${wcode}/"

        cd ${rpath}
	rm -rf ${svnpath}
	/web/svn/bin/svn checkout svn://localhost/${wcode} > ${infospath}_co.txt

	deletepsvn ${scode}
	deletefpath ${svnpath}

	cp -r ${scode}* ${svnpath}

	svn_status="${rpath}s${wcode}.txt"
	/web/svn/bin/svn status ${svnpath} > ${svn_status}
	cp ${svn_status} ${infospath}_status.txt

	svn_deal="${rpath}d${wcode}.sh"

	awk '{if ($1=="!") print "/web/svn/bin/svn delete "$2}' ${svn_status} | sed -e 's/\(.*\)\(\/home.*\)/\1\"\2\"/g' >${svn_deal}
	awk '{if ($1=="?") print "/web/svn/bin/svn add "$2}' ${svn_status}  |  sed -e 's/\(.*\)\(\/home.*\)/\1\"\2\"/g' >>${svn_deal}
	#awk '{if ($1=="~") print "rm "$2}' ${svn_status}>>${svn_deal}

	cp ${svn_deal} ${infospath}_deal.txt
	chmod +x ${svn_deal}
	`${svn_deal}`

	/web/svn/bin/svn commit ${svnpath} -m "${mcomments}" > ${infospath}_cm.txt
done

