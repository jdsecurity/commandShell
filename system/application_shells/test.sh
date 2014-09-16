#!/bin/bash
# test operation!
# type:
# 	-e(source) -f(file) -d(path) -b(block) -c(character) 
# 	-S(Socket) -p(pipe) -L(links)
# privilege:
#	-r(read) -w(write) -x(execute) -u(have SUID) 
#	-g(have SGID) -k(have sticky bit) -s(no empty file)
# test file1 .. file2
# 	-nt(newer than) -ot(older than) -ef(is same file based hard link)
# test number1 .. number2
# 	-eq(equal) -ne(not equal) -gt(greater than)
# 	-lt(less than) -ge(greater than or equal) -le(less than or equal)
# test string
#	-z(is empty?) -n(is not empty?) str1=str2(string equal) str1!=str2(string no equal)
# mul test
#	-a(and) -o(or) !

basePath=$1
baseType=$2
if [ -d ${basePath} ]; then
    #echo ${basePath}
    for fileInfo in `ls ${basePath}`
    do
        #echo ${fileInfo}
        echo "-${baseType} ${fileInfo} "
        fullFilePath="${basePath}/${fileInfo}"
        if [ -${baseType} ${fullFilePath} ]; then
            echo "${baseType} is true!"
        fi
    done
fi
