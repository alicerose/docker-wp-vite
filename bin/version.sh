#!/usr/bin/env bash

# Gitのハッシュをファイルに出力

# echoの文字色
END=$(printf '\e[m')
BGGREEN=$(printf '\e[30;46;1m')
BGRED=$(printf '\e[30;41;1m')
GREEN=$(printf '\e[36;1m')
RED=$(printf '\e[31;1m')
YELLOW=$(printf '\e[32;1m')

GIT_HASH=$(git rev-parse HEAD)

LF=$(printf '\\\012_')
LF=${LF%_}
if [ -e ./src/templates/.version ]; then
  echo "${BGGREEN} VERSION ${END} file found."
else
  echo "version file initialized." > ./src/templates/.version
  echo "${BGGREEN} VERSION ${END} file generated. ${END}"
fi
if [ -e ./dist/themes/wds/.version ]; then
  echo "${BGGREEN} VERSION ${END} file found."
else
  echo "version file initialized." > ./src/templates/.version
  echo "${BGGREEN} VERSION ${END} file generated. ${END}"
fi
echo "${BGGREEN} VERSION ${END} set version to : ${GIT_HASH}"
sed -i '' -e $"1s/^/${GIT_HASH}${LF}/" ./src/templates/.version