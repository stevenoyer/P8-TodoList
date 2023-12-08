ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

# Nouvelles fonctionnalités
- [ ]  Chaque tâche créée doit-être relié à un utilisateur.
- [ ]  Lors de la modification de la tâche, l’auteur ne peut être modifié.
- [ ]  Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.
- [ ]  Lors de la création d’un utilisateur, il doit être possible de choisir un rôle : ROLE_USER ou ROLE_ADMIN.
- [ ]  Lors de la modification d’un utilisateur, il doit être possible de changer le rôle.
- [ ]  Seuls les utilisateurs ayant le rôle administrateur (*ROLE_ADMIN*) doivent pouvoir accéder aux pages de gestion des utilisateurs.
- [ ]  Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en question.
- [ ]  Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (*ROLE_ADMIN*).
- [ ]  Faire des tests qui doivent être implémentés avec **PHPUnit.**
- [ ]  Utiliser Behat pour la partie fonctionnelle.
- [ ]  Prévoir des données de tests afin de pouvoir prouver le fonctionnement dans les cas explicités dans ce document.
- [ ]  Fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70 %.
- [ ]  Produire une documentation expliquant comment l’implémentation de l'authentification a été faite.
- [ ]  Cette documentation se destine aux prochains développeurs juniors qui rejoindront l’équipe dans quelques semaines. Dans cette documentation, il doit être possible pour un débutant avec le framework Symfony de **comprendre quel(s) fichier(s) il faut modifier et pourquoi**, **comment s’opère l’authentification** et **où sont stockés les utilisateurs**.
- [ ]  Produire un document expliquant comment devront procéder tous les développeurs souhaitant apporter des modifications au projet. Ce document devra aussi détailler le processus de qualité à utiliser ainsi que les règles à respecter.
- [ ]  Produire un audit de code sur les deux axes suivants : la qualité de code et la performance (utiliser Codacy ou CodeClimate pour auditer la qualité du code et utiliser Blackfire ou New Relic pour auditer la performance)
