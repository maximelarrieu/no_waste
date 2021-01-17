# NO WASTE
###### DELBREL Antoine, KERSULEC Alexandre, LARRIEU Maxime

### Sommaire
+ [Présentation du projet](#présentation-du-projet)
+ [Fonctionnalités](#fonctionnalités)
+ [Problèmes rencontrés](#problèmes-rencontrés)
+ [Nota bene](#nota-bene)  
+ [Get started](#get-started)

### Présentation du projet
Dans le cadre de nos cours Symfony, nous vous présentons notre projet NO WASTE qui
lutte contre le gaspillage alimentaire en aidant les commerçants durant
cette dure période de crise.

Durant cette période, vous pourrez aider les commerces de proximités qui vous entoure tout en réduisant
le gaspillage alimentaire.

Les commerçants peuvent sur ce site mettre en vente des paniers repas à prix coûtant,
parmi le stock qu'ils n'ont pas pu vendre.

En tant que consommateur, accédez à la liste des commerçants et de leurs produits mis
en vente et achetez ce qui vous fait plaisir.

Une interface sera mise à disposition pour chaque commerçant afin qu'il puisse suivre
l'évolution de leurs ventes.

### Fonctionnalités
CLIENT :

+ Navigation simple entre les produits disponibles et les commerces de la plateforme.
+ Ajout d'un article dans son panier.
+ Modification de son profil.
+ Ajout de son business sur la plateforme.
+ Historique des commandes passées.

ADMINISTRATION :

+ Dashboard avec différentes statistiques.
+ Liste des commerces modifiables/supprimables.
+ Liste des utilisateurs modifiables/supprimables.
+ Ajout d'un commerce sur la plateforme.

### Problèmes rencontrés

+ Il se peut que les fixtures ne passent pas au premier lancement, cause d'une mauvaise relation entre les entités. Deux ou trois tentatives devraient suffire.
+ Mise en place de mails mensuels aux gérants générant un récapitulatif du chiffre d'affaire du mois.

### Nota bene
Le serveur mail mis en place est fait avec GMail.

Pour vérifier la bonne réception des mails de confirmation de votre commande, je vous invite à créer un utilisateur avec votre propre adresse mail.
Ou modifier la ligne 35 du [PurchaseController](/src/Controller/PurchaseController.php) avec votre adresse mail.

---

Les utilisateurs sont créés avec le mot de passe : `password`.

L'administrateur se connecte avec : `Email : admin@admin.com | Password : admin`.

### Get started
Suivez la [documentation](get_started.md) afin de lancer le projet et de profiter de toutes
les interfaces mises en place.