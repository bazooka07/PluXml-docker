# les versions possibles de PHP sont: 5.6, 7.0 et 7.1

FROM	php:7.1-apache
LABEL	maintainer="J.P Pourrez <kazimentou@free.fr>" \
	description="PHP pour PluXml multi-versions. La version utilisée de PHP peut-être modifiée dans la directive FROM du fichier Dockerfile."

# Plus d'infos à : https://hub.docker.com/_/php/

# on est dans le dossier /var/www/html
# on utilise un dossier plugins communs a toutes les versions
# wget et unzip sont absents.
# Par contre, il y a curl.

RUN	apt-get update && apt-get -y upgrade \
#installation de la librairie php-gd
&&	apt-get -y install \
	unzip \
	libfreetype6 libjpeg62-turbo libmcrypt4 libzip2 \
	libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng12-dev libzip-dev \
&&	sed -i '/LS_OPTIONS/,+4s/^#\s*//' /root/.bashrc \
&&	sed -i '/force_color_prompt=/s/^#\s*//' /etc/skel/.bashrc \
&&	docker-php-ext-install -j$(nproc) iconv mcrypt \
&&	docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&&	docker-php-ext-install -j$(nproc) gd \
&&	pecl install zip \
&&	pecl install xdebug \
&&	docker-php-ext-enable zip xdebug \
&&	apt-get -y purge libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng12-dev libzip-dev

RUN	a2enmod rewrite

COPY	bin /usr/local/bin/
COPY	extras /usr/local/share/
RUN	chmod ug+x /usr/local/bin/install-*.sh \
&&	chown -R www-data:www-data /usr/local/share/pluxml

VOLUME	/var/www/html

ENTRYPOINT service apache2 restart && /bin/sh

CMD ["bash"]