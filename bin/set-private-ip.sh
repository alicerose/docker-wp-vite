#!/usr/bin/env bash

ifconfig en0 | awk '$1 == "inet" {print $2}' > ./src/templates/.hostip
