# Présentation

- Cette image pour Docker permet de créer des sites selon plusieurs versions de PluXml.
- Elle permet également de tester les plugins et les thèmes sous différentes versions de PluXml.
- Pour tester PluXml sous différentes version de PHP, créez une image pour chaque version de PHP après avoir préciser la version dans le fichier Dockerfile.

# Installation de Docker sous Ubuntu :

- https://doc.ubuntu-fr.org/docker
- https://docs.docker.com/engine/installation/linux/ubuntu/#install-using-the-repository

# Construction de l'image pour Docker

Dans ce dossier, executez la commande

`docker build -t pluxml-php-5.6 .`

Notez bien la présente du point final.

# Utilisation
Vérifier que vous avez un dossier vide sites et lancez Docker avec la commande suivante:

`docker run -i -t -v $(PWD)/sites:/var/www/html pluxml-php-5.6`

Notez l'adresse IP affichée après "using", par exemple : using 172.17.0.2.

A la première utilisation, vous devez installer les différentes versions de PluXml pour votre image Docker avec la simple commande :

`install.sh`

Tapez ensuite dans votre navigateur Internet préféré, l'adresse IP notée ci-dessus et poursuivez l'utilisation de PluXml comme habituellement.

Pour mettre fin à la session, revnir dans la console en ligne et tapez sur les touches Ctrl-D.
Constatez que les différentes modifications faites avec PluXml sont sauvegardées dans le dossier sites pour être utilisées la prochaine fois.