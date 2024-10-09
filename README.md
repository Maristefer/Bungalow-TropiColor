# Bungalow-TropiColor
Bienvenue dans le projet de Location de Bungalow. Ce guide vous accompagnera dans le processus d'installation et de configuration de l'application pour l'exécuter sur votre environnement local ou un serveur distant. Assurez-vous de suivre les instructions étape par étape.
# Prérequis
Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

PHP 8.3,
Composer,
Wamp,
Node.js et npm,
FileZilla.
# Installation
## Cloner le dépôt
Commencez par cloner le dépôt sur votre machine locale à l'aide de la commande suivante :

## Utiliser Wamp
Clonez le dépôt GitHub dans le répertoire www de votre installation Wamp :

Assurez-vous que Wamp est en cours d'exécution et que le serveur Apache est démarré.
## Configuration du fichier .env
Le fichier .env contient toutes les variables d'environnement nécessaires pour configurer l'application, notamment les informations de connexion à la base de données.

Créez un fichier .env à la racine du projet si ce n'est pas déjà fait, et ajoutez-y les informations suivantes :

DB_HOST=localhost

DB_NAME=nom_de_votre_bdd

DB_USER=votre_utilisateur

DB_PASSWORD=votre_mot_de_passe
## Configuaration de la base de données
Importez la base de données du projet dans votre système de gestion de base de données (par exemple, phpMyAdmin) :

1. Ouvrez phpMyAdmin ou votre outil de gestion de base de données préféré.

2. Créez une nouvelle base de données nommée projet.

3. Importez le fichier SQL fourni dans la base de données nouvellement créée.
## Installation PHP dépendances
Accédez au répertoire du projet et installez les dépendances PHP à l'aide de Composer :

composer install

composer update

## Installation des dépendances JavaScript
Accédez au répertoire du projet et installez les dépendances JavaScript à l'aide de npm :

npm install

## Exécution du projet
Assurez-vous que Wamp est en cours d'exécution et que le serveur Apache est démarré. Ouvrez votre navigateur Web et accédez à 

http://localhost/your-project-directory.
## Troubleshooting
Wamp Issues: Ensure that no other programs are using the same port as Apache (usually port 80). Composer Issues: Make sure you have the latest version of Composer installed. Node.js Issues: Ensure that Node.js and npm are correctly installed and their versions are up to date.
# Déploiement
## Transfert des fichiers via FTP
Pour déployer le projet en ligne :

1. Ouvrez FileZilla et connectez-vous à votre serveur FTP avec les informations fournies par votre hébergeur.
2. Transférez tous les fichiers du projet sur le serveur, dans le répertoire prévu pour votre site web.
3. Vérifiez que les permissions des fichiers et dossiers sont correctement définies (généralement 755 pour les dossiers et 644 pour les fichiers).
