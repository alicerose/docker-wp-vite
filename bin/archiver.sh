#!/usr/bin/env bash

# echoの文字色
END=$(printf '\e[m')
BGGREEN=$(printf '\e[30;46;1m')
BGRED=$(printf '\e[30;41;1m')
GREEN=$(printf '\e[36;1m')
RED=$(printf '\e[31;1m')
YELLOW=$(printf '\e[32;1m')

GIT_HASH=$(git rev-parse HEAD)

# 引数なしなら中断
if [[ $# == 0 ]]; then
    echo  "${BGRED} ARCHIVER ${END} ${RED}ERROR:${END} no params given, aborting."
    exit 0
fi

# アーカイブ名を環境変数から取得
export $(cat ./.env | grep -v ^# | xargs);

# アーカイブ名設定がされてなければ中断
if [[ -z "$ZIP_NAME" ]]; then
  echo "${BGRED} ARCHIVER ${END} ${RED}ERROR:${END} archive name undefined, aborting."
  exit 0
fi

export NODE_ENV=$NODE_ENV
#npm run build:"${1}"
npm run build

LF=$(printf '\\\012_')
LF=${LF%_}
if [ -e ./dist/.version ]; then
  echo "${GREEN} Version file found. ${END}"
else
  echo "version file initialized." > ./dist/.version
  echo "${GREEN} Version file generated. ${END}"
fi
sed -i '' -e $"1s/^/${GIT_HASH}${LF}/" ./dist/.version

cd ./dist || exit
zip -r "${ZIP_NAME}" ./ --exclude=.DS_Store
mv "${ZIP_NAME}".zip ../

echo "${BGGREEN} ARCHIVER ${END} ${GREEN}${ZIP_NAME}.zip${END} generated for ${YELLOW}$1${END} server."