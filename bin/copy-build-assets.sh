#!/usr/bin/env bash

DIR=$(pwd)

echo "${DIR}"

cp -Rpv "${DIR}"/src/assets "${DIR}"/dist

echo "Assets copied."