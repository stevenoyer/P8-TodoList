# Documentation de contribution pour P8-TodoList

Bienvenue dans la documentation de contribution pour le projet P8-TodoList! Nous sommes ravis que vous envisagiez de contribuer à notre projet. Cette documentation vous guidera à travers le processus de contribution, en vous fournissant des instructions claires et des lignes directrices pour vous aider à proposer des changements et des améliorations de manière efficace.

## Pré-requis

Avant de commencer à contribuer, assurez-vous de disposer des éléments suivants :

- PHP version 8.3 ou supérieure installée sur votre machine.
- Connaissance de base de Symfony 6.4.
- PHPUnit pour les tests unitaires.
- Compte GitHub pour pouvoir soumettre des pull requests.

## Processus de contribution

### 1. Fork du projet

Commencez par créer un fork du projet en cliquant sur le bouton "Fork" en haut à droite de la page du projet sur GitHub. Cela créera une copie du projet dans votre propre compte GitHub.

### 2. Clonage du projet

Clonez votre fork localement sur votre machine :

```
git clone https://github.com/stevenoyer/P8-TodoList
```

### 3. Installation des dépendances

Assurez-vous d'installer toutes les dépendances en utilisant Composer :

```
composer install
```

### 4. Développement sur la branche "dev"

Tous les développements doivent être effectués sur la branche dev. Assurez-vous de basculer sur cette branche avant de commencer à travailler :

```
git checkout dev
```

### 5. Travail sur une nouvelle fonctionnalité ou un correctif

Créez une nouvelle branche à partir de la branche dev pour travailler sur votre fonctionnalité ou votre correctif :

```
git checkout -b nom-de-ma-fonctionnalite-ou-correctif
```

### 6. Tests unitaires et audits de code

Avant de soumettre votre code, assurez-vous d'écrire des tests unitaires avec PHPUnit pour valider vos modifications. Vous pouvez exécuter les tests avec la commande suivante :

```
php bin/phpunit
```

### 7. Soumission d'une Pull Request

Une fois vos modifications terminées et testées, poussez votre branche sur votre fork GitHub et soumettez une pull request (PR) à partir de votre branche vers la branche dev du projet principal.

Assurez-vous de décrire clairement les modifications apportées dans votre PR.

### 8. Attente de validation

Un administrateur du projet examinera votre PR. Assurez-vous de surveiller les commentaires et d'apporter des modifications si nécessaire.

Une fois que votre PR est approuvée, elle sera fusionnée dans la branche dev du projet principal.

## Contribution continue

Votre contribution ne se termine pas avec l'approbation de votre PR. Nous encourageons les contributeurs à rester engagés avec le projet en :

- Participant aux discussions.
- Soumettant et révisant des issues.
- Contribuant à la documentation.
- Proposant des améliorations de fonctionnalités.

Nous vous remercions de votre intérêt pour le projet P8-TodoList et nous sommes impatients de voir vos contributions! Si vous avez des questions ou des préoccupations, n'hésitez pas à les poser dans les discussions du projet.
