#!/bin/sh

if $(ls -d PluXml-* > /dev/null 2>&1); then
	echo "Les différentes versions de PluXml sont déjà installées :"
	ls -d PluXml-*
	exit 0
fi

echo "Installation des différentes versions de PluXml :"

URL_BASE="https://github.com/pluxml/PluXml/archive/"
# VERSIONS="5.3.1 5.4 5.5 5.6"
VERSIONS="5.6 5.5 5.4"
TMPFILE="$(mktemp /tmp/pluxml-XXXXX.zip)"
TARGET="/var/www/html"
EXTRA_LIB="/usr/local/share/pluxml"

cd ${TARGET}
rm -fR *

mkdir plugins
chown www-data plugins

for version in ${VERSIONS}; do
	echo -n "$version"
	curl -Ls -o ${TMPFILE} ${URL_BASE}${version}.zip
	echo -n ", "
	unzip -q ${TMPFILE}
	old_plugins="PluXml-${version}/plugins"
	rm -R ${old_plugins}
	ln -s $(pwd)/plugins ${old_plugins}
	rm -R PluXml-${version}/data
	# rm PluXml-${version}/config.php
	chown -R www-data PluXml-${version} PluXml-${version}/config.php PluXml-${version}/themes
	rm "PluXml-${version}/install.php"
	ln -s "${EXTRA_LIB}/install.php" "PluXml-${version}/install.php"
done
echo "\n"
rm -f ${TMPFILE}

INDEX="${EXTRA_LIB}/pluxml.php"
chown www-data ${INDEX}
ln -s ${INDEX} index.php

echo "Ready to serve !"