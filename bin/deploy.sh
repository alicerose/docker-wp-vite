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
    echo  "${BGRED} DEPLOY ${END} ${RED}ERROR:${END} no params given, aborting."
    exit 0
fi

#パラメータ郡
# ${1} デプロイ対象環境 develop / production

# 事故防止のためデプロイ先環境を再入力させる
read -r -p "${BGGREEN} DEPLOY ${END} Confirm deploy target: " target
case "$target" in [${1}]*) ;; *) echo "${BGRED} DEPLOY ${END} ${RED}ERROR:${END} Deploy target didn't match with command, aborting."; exit;; esac

# デプロイ先を環境変数から取得
export $(cat ./.env.${1} | grep -v ^# | xargs);

# デプロイ先設定がされてなければ中断
if [[ -z "$APP_DEPLOY_TARGET" ]]; then
  echo "${BGRED} DEPLOY ${END} ${RED}ERROR:${END} deploy target undefined, aborting."
  exit 0
fi

export NODE_ENV=$NODE_ENV
npm run build:${1}

LF=$(printf '\\\012_')
LF=${LF%_}
if [ -e ./dist/.version ]; then
  echo "${GREEN} Version file found. ${END}"
else
  echo "version file initialized." > ./dist/.version
  echo "${GREEN} Version file generated. ${END}"
fi
sed -i '' -e $"1s/^/${GIT_HASH}${LF}/" ./dist/.version

echo "${BGGREEN} DEPLOY ${END} deploying ${GREEN}/dist/${END} to ${YELLOW}$1${END} server at ${YELLOW}$APP_DEPLOY_TARGET${END}"
rsync -rchv --progress --delete --exclude '.git' ./dist/ ${APP_DEPLOY_TARGET}
status_app=$?
echo $?

# 終了ステータスで分岐（APP)
if [[ ${status_app} == "0" ]]; then
  echo "${BGGREEN} DEPLOY ${END} ${GREEN}Successfully deployed${END} to ${YELLOW}$1${END} server."
  echo "${BGGREEN} DEPLOY ${END} Deployed at: $APP_URL"
else
  echo "${BGRED} DEPLOY ${END} ${RED}ERROR:${END} Deploying APP failed."
fi

exit $?
