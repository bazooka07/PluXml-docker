# Présentation

- Configuration pour Docker qui permet de tester différentes versions de PluXml.
- Possibilité de choisir la version de PHP 5.6, 7.0 ou 7.1. Il faut créer une image par version.
- Vérification de la compatibilité des plugins sous différentes versions de PluXml.
- Possibilité d'avoir plusieurs sites pour une même version de PluXml.

# Installation de Docker sous Ubuntu :

- https://doc.ubuntu-fr.org/docker
- https://docs.docker.com/engine/installation/linux/ubuntu/#install-using-the-repository

# Construction de l'image pour Docker

- Placez-vous dans le dossier contenant le fichier **Dockerfile**
- Vérifier que la version choisie de PHP dans Dockerfile vous convient (PHP 7.1 par défaut)
- Générer l'image pour Docker avec la commande:

`docker build -t pluxml:php7.1 .`

- Si vous préférez utiliser PHP 5.6, adaptez la directive **RUN** dans Dockerfile et générez l'image pour Docker :

`docker build -t pluxml:php5.6 .`

- Idem pour PHP 7.0
- Notez bien la présence du point final . à la fin de la commande pour Docker
- Vous devez générer une image pour chaque version de PHP utilisée.
- Vérifiez la présence des images générées avec la commande :

`docker images`

# Utilisation

Par défaut, les images ne contiennent aucune version de PluXml ou site Web.

Pour sauvegarder les sites que vous allez créer avec PluXml, il faut créer ou choisir un dossier pour les stocker et préciser ensuite leurs adresses absolues.
Vous pouvez utiliser le dossier existant vide sites.

Lancez Docker avec la commande suivante en modifiant la version de PHP si besoin :

`docker run -i -t -v $(PWD)/sites:/var/www/html pluxml:php7.1`

-i permet de rester en mode inter-actif avec Docker. -t permet de démarrer un pseudo-terminal pour taper des lignes de commandes comme sous Linux. -v permet de monter votre dossier local sites dans le dossier /var/www/html de l'image lancée par Docker.

Notez l'adresse IP affichée après "using", par exemple : using 172.17.0.2.

A la première utilisation, vous devez installer les différentes versions de PluXml pour votre image Docker avec la simple commande :

`install-pluxml.sh`

Pour installer un plugin, récupérez l'adresse URL pour télécharger son archive zip et utilisez la commande :

`install-plugin.sh "http://mon-depot.com/mon-beau-plugin.zip"`

Veillez à ce que l'archive du plugin soit conforme aux spécifications de PluXml, en particulier si elle vient de Github.com.

Notez que le plugin est commun à toutes les versions installées de PluXml pour vérifier sa compatibilité.

Pour utiliser PluXml avec Docker, tapez l'adresse IP ci-dessus, en principe 172.17.0.2, dans votre navigateur et suivez les instructions affichées.

Pour mettre fin à la session, revenir dans la console en ligne et tapez sur les touches Ctrl-D.

Constatez que les différentes modifications faites avec PluXml sont sauvegardées dans le dossier sites pour être utilisées la prochaine fois.

Si vous avez déjà un site tournant sous PluXml, vous pouvez copier son dossier de données (data) et son thème dans le dossier sites dans une des versions de PluXml. Attention, les différentes versions de PluXml ne sont pas rétro-compatibles.

# Remarques diverses

Les fichiers install.php des différentes versions de PluXml ne permettent pas de créer directement un nouveau site.
Une nouvelle mouture a été créée et fait partie de chaque image de Docker. Pour chaque version de PluXml un lien symbolique est créé vers ce fichier.

Si vous supprimez ce lien comme recommandé dans la version 5.6 de PluXml, vous pouvez le re-créer avec la commande suivante:

`ln -s /usr/local/share/pluxml/install.php /var/www/html/PluXml-5.6/`

L'image originelle pour créer les images ci-dessus est basée sur Debian. En conséquence, vous pouvez utiliser la commande `apt-get` pour installer ponctuellement d'autres logiciels comme tree, mc ou vim. Les utilitaires curl et unzip sont installés par défaut.

Les extensions suivantes pour PHP sont installées : gd, zip et xdebug.

Les images générées pour Docker sont testées sur Ubuntu 16.10. Il y a de fortes chances qu'elles fonctionnent sous d'autres versions de Linux. Pour Windows, il faut au minimum Windows 10 professionnel.