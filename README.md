# Projet Zoo Arcadia

Venez découvrir notre zoo ! Proche de la foret de Brocéliande depuis 1960 nous avons à cœur de veiller au bien-être de nos animaux. Vous pourrez les observer au sein de trois habitats : la savane, la jungle et le marais. Vous pourrez également profiter de nos services tel que notre restaurant, une visite guidée gratuite ou bien même notre fameuse visite en petit train.

## Prérequis

Avant de commencer, assurez-vous d’avoir installé tous les éléments suivants sur votre système :
- [GIT] (https://git-scm.com/book/fr/v2/D%C3%A9marrage-rapide-Installation-de-Git)
- [PHP] (https://www.php.net/manual/fr/install.php)
- [MySQL] (https://dev.mysql.com/downloads/installer/)
- [MongoDB] (https://www.mongodb.com/docs/manual/installation/)
- [Composer] (https://getcomposer.org/download/)
-  [Le pilote PHP_MongoDB] (https://www.mongodb.com/docs/drivers/php-drivers/)
- le script de la base de données MySQL présente dans le dossier Base de données

## Installation

Afin d'installer le projet sur votre environnement local, veuillez suivre les prochaines étapes :

## Cloner le dépôt

```bash
git clone git@github.com:Lucy86240/Zoo-Arcadia.git
```

## Configuration

### Initiez l'application avec composer :
Dans votre terminal, à la racine :

```bash
composer init
```
Puis répondez aux questions.
Vous avez désormais un fichier composer.json à la racine du projet.

### Créez le fichier vendor/autoload :
```bash
composer dump-autoload
```

### Ajoutez la librairie MongoDB:
```bash
composer require mongodb/mongodb
```

### Configurez les variables d'environnement :
Dans le fichier 'config.php' (à la racine de l'application) modifiez les constantes suivantes:
SITE_URL correspond à l’url du projet
MAIL_CONTACT correspond à l’adresse mail à laquelle est envoyée les demandes de contact
DATA_BASE correspond à l’hôte et nom de la base de données MySQL
USERNAME_DB correspond au nom d’utilisateur de la base de données MySQL
PASSEWORD_DB correspond au mot de passe de la base de données MySQL
MONGO_DB_HOST correspond à l’hôte de la base de données MongoDB 
Dans le fichier CONSTANTES_inputs.js modifiez la constante SITE_URL (idem que dans le fichier config.php).

## Bases de données

### MySQL

Dans le dossier base de données vous trouverez un fichier arcadia_zoo.sql Utilisez un outil comme XAMPP, WAMP ou MAMP afin de gérer la base de données MySQL.

* Ouvrez votre navigateur et accédez à PhpMyAdmin .
* Connectez-vous avec vos identifiants de connexion pour à PhpMyAdmin. (paramètre par défaut : nom utilisateur: root et champ de mot de passe vide).
* Créez une nouvelle base de données, en utilisant le même nom que dans la variable DATA_BASE, puis cliquez sur le bouton "Créer".
* Importez le script SQL, pour ce faire, cliquez sur votre base de données dans la barre latérale de gauche afin de la sélection puis recherchez l'onglet importer dans le panneau supérieur. Sur la page d'importation, vous devrez cliquer sur le bouton parcourir et choisir le fichier "arcadia_zoo.sql". Une fois sélectionné, faites défiler vers le bas et cliquez sur le bouton "Exécuter" afin d'importer le script SQL dans la base de données.
* Une fois que l'importation à été faite, vous pouvez vérifier que toutes les tables ont bien été créées. Pour ce faire, cliquez sur le nom de votre base de données et sur le panneau de gauche afin d'afficher les tableaux.

En suivant ces étapes vous aurez importé la structure nécessaire de votre base de données via le fichier "arcadia_zoo.sql" dans PhpMyAdmin, et l'application sera prête à utiliser cette base de données pour stocker et récupérer des données.

MongoDB : 

Utilisez un outil comme MongoDB Compass pour créer la base de données.

* Ouvrez MongoDB Compass
* Connectez vous en utilisant le même hôte que MONGO_DB_HOST.
* Cliquez sur le + à coté de votre connexion.
* Saisir :
Database Name : Arcadia 
Collection Name : schedules
Puis cliquez sur Create Database
Vous venez de créer la base de données qui doit désormais apparaître parmis les bases en dessous de votre connexion. 
* Survolez la base de données Arcadia. Cliquez sur le +.
Saisissez dans Collection Name : popularity
Cliquez sur Create Collection. Vous venez de créer la collection popularity.
* Cliquez sur schedules (en dessous de votre base de données)
La collection s’affiche.
* Faites ADD DATA et copiez :
```bash
{
 "_id": {
 "$oid": "66cc2e4fd0dddc950f57491e"
 },
 "text": "Ouvert 362 j/an. \r\nDe 9h à 19h du 1er avril au 30 septembre et de 9h à 18h le reste de l'année. \r\nDernières visites 2h avant fermeture."
}
```

En suivant ces étapes vous aurez créé la structure nécessaire de votre base de données MongoDB, et l'application sera prête à utiliser cette base de données pour stocker et récupérer des données.

## Démarrer l’application :

Dans le terminal de votre éditeur de code saisissez :
```bash
php -S localhost:3000
```
Utilisez le même hôte que ce que vous avez saisie dans la variable SITE_URL
