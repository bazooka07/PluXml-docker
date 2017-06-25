#!/bin/sh

TMPFILE="$(mktemp /tmp/plugin-XXXXX.zip)"
TARGET="/var/www/html/plugins"
curl -L -o ${TMPFILE} $1 && unzip -d ${TARGET} ${TMPFILE}
rm -f ${TMPFILE}
echo "============ Liste des plugins ==============="
ls -dlt --color ${TARGET}