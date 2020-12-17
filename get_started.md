# GET STARTED
### Cloner le dépôt
`git clone https://github.com/maximelarrieu/no_waste.git`

### Installer les dépendances
`composer install`

### Modifier le .env pour le connecter à votre serveur de données
`DATABASE_URL="db_language://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=db_version"`

### Créer la base de données
`php bin/console doctrine:migrations:migrate`

### Ajouter les fixtures
`php bin/console doctrine:fixtures:load`

### Lancer webpack (CSS / JS)
`yarn encore dev`

### Lancer le serveur local
`symfony server:start`