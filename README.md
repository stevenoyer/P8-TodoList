# TodoList - Symfony 6.4

Bienvenue dans le projet P8-TodoList! Ce projet est une application de gestion de liste de tâches développée avec Symfony.

## Pré-requis

Avant de pouvoir utiliser ce projet, assurez-vous d'avoir les éléments suivants installés sur votre système :

- PHP >= 8.3
- Composer
- Git
- Symfony CLI
- Une base de données

## Installation

Suivez les étapes ci-dessous pour cloner et installer le projet sur votre machine :

### Étape 1. Clonez le dépôt GitHub dans le répertoire de votre choix en exécutant la commande suivante dans votre terminal

```
git clone https://github.com/stevenoyer/P8-TodoList.git
```

### Étape 2. Accédez au répertoire du projet :

```
cd P8-TodoList
```

### Étape 3. Installez les dépendances PHP en exécutant la commande suivante :

```
composer install
```

### Étape 4. Créez une copie du fichier .env :

```
cp .env.dist .env
```

### Étape 5. Configurez votre base de données dans le fichier .env en modifiant les paramètres suivants (ex: MySQL) :

```
DATABASE_URL=mysql://user:password@host:port/database_name
```

Remplacez user, password, host, port et database_name par les informations de connexion à votre base de données.

### Étape 6. Créez la base de données en exécutant la commande suivante :

```
php bin/console doctrine:database:create
```

### Étape 7. Appliquez les migrations pour créer les tables de la base de données :

```
php bin/console doctrine:migrations:migrate
```

### Étape 8. Exécutez les fixtures

```
php bin/console doctrine:fixtures:load
```

### Étape 9. Démarrez le serveur web local :

```
php bin/console server:start OU symfony serve
```

L'application sera accessible à l'adresse http://localhost:8000 dans votre navigateur.

## Utilisation

Une fois l'installation terminée, vous pouvez accéder à l'application dans votre navigateur à l'adresse http://localhost:8000. Vous pouvez vous connecter avec les identifiants par défaut ou créer un nouveau compte.

### Comptes par défaut

#### > Admin

Utilisateur : admin <br>
Mot de passe : admin

#### > Test

Utilisateur : test <br>
Mot de passe : test

#### > Anonymous (utilisateur anonyme)

Utilisateur : anonymous <br>
Mot de passe : anonymous

## Tests

Pour effectuer les tests de l'application, veuillez suivre les instructions ci-dessous :

### Étape 1. Fixtures pour l'environnement test

```
php bin/console doctrine:fixtures:load --env=test
```

> **_NOTE:_** _Avant d'exécuter chaque test, veuillez vous assurer d'exécuter la commande suivante pour garantir le bon déroulement du processus._

### Étape 2. Générer le rapport de couverture de code

```
vendor/bin/phpunit --coverage-html public/test-coverage
```

### Étape 3. Lancer tous les tests unitaires

```
vendor/bin/phpunit
```

### Étape 4. Lancer un test sur une méthode en particulier

```
vendor/bin/phpunit --filter=votreMethode
```
