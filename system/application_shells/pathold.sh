#!/bin/bash

# Rename filename
ROOT_PATH='/home/wangcanliang/special/'
EXT='swf'

for OUT_PATH_NAME in `ls ${ROOT_PATH}`
do

for PATH_NAME in `ls ${ROOT_PATH}${OUT_PATH_NAME}`
do
    echo $PATH_NAME
    PATHS=${ROOT_PATH}/${OUT_PATH_NAME}/${PATH_NAME}
    mkdir -p "/home/wangcanliang/thumb/${OUT_PATH_NAME}/"${PATH_NAME}
    PATHJPG="/home/wangcanliang/thumb/${OUT_PATH_NAME}/"${PATH_NAME}
    i=0
    #echo ${PATHS}/*.${EXT}
    for FULL_NAME in `find ${PATHS}/*.$EXT`
    do
        OLD_NAME=${FULL_NAME}
        DATE=`date +%Y%m%d`
        SUFFIX=`echo $i | awk '{printf "%04d", $1}'`
        NEW_NAME=${DATE}${SUFFIX}
        BASE_OLD_NAME=`basename ${OLD_NAME}`
        BASE_OLD_NAME=${BASE_OLD_NAME%.${EXT}}
        TXTFILE=${PATHS}/${BASE_OLD_NAME}.txt
        JPGFILE=${PATHS}/${BASE_OLD_NAME}.jpg
	JPGFILEEXT=${PATHS}/${BASE_OLD_NAME}.JPG
        SWFFILE=${PATHS}/${BASE_OLD_NAME}.swf

        if [ -f ${TXTFILE} ]; then
            CONTENT=`cat ${TXTFILE}`
            rm -f ${TXTFILE}
        fi

        THUMBURL=''
        if [ -f ${JPGFILE} ]; then
            THUMBURL=${PATHJPG}/${PATH_NAME}${NEW_NAME}.jpg
            mv ${JPGFILE} ${PATHJPG}/${PATH_NAME}${NEW_NAME}.jpg
            echo ${JPGFILE}
        fi

        if [ -f ${JPGFILEEXT} ]; then
            THUMBURL=${PATHJPG}/${PATH_NAME}${NEW_NAME}.jpg
            mv ${JPGFILEEXT} ${PATHJPG}/${PATH_NAME}${NEW_NAME}.jpg
            echo ${JPGFILEEXT}
        fi


        if [ -f ${OLD_NAME} ]; then
#echo ${OLD_NAME}
            SWFURL=${PATHS}/${PATH_NAME}${NEW_NAME}.${EXT}
            mv ${OLD_NAME} ${PATHS}/${PATH_NAME}${NEW_NAME}.${EXT}
        fi
        i=$(($i+1))

        `echo "INSERT INTO games(name, swf, content, thumb, special) VALUES('"${BASE_OLD_NAME}"'","'"${SWFURL}"'","'"${CONTENT}"'","'"${THUMBURL}"'","'"${PATH_NAME}"');" >> games.sql`
    done
done
done
~

