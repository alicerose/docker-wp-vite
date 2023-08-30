#!/usr/bin/env bash

# echoの文字色
END=$(printf '\e[m')
BGGREEN=$(printf '\e[30;46;1m')
BGRED=$(printf '\e[30;41;1m')
GREEN=$(printf '\e[36;1m')
RED=$(printf '\e[31;1m')
YELLOW=$(printf '\e[32;1m')

cd src/assets/images || exit
Files=$(find . -type f -iname '*'.jpg -o -iname '*'.jpeg -o -iname '*'.png)
echo "${BGGREEN} WEBP CONVERT ${END} Start"
echo "----------------"
for File in $Files
do
    echo $File
#    FILE_DIRE="${File%/*}"/
#    FILE_NAME=$(basename ${File%.*})
#    FILE_PATH=$FILE_DIRE$FILE_NAME
    cwebp -preset photo -metadata icc -sharp_yuv -o $File".webp" -progress -short $File
    echo "----------------"
done
echo "${BGGREEN} WEBP CONVERT ${END} Done"
