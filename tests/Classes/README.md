# Lancement des commandes

## Commandes de base

### Lancer le projet

```bash
composer install
php -S localhost:8080 -t public
```

### Lancer les tests

```bash
./vendor/bin/phpunit tests
```

### Lancer les tests avec un rapport de couverture

```bash
./vendor/bin/phpunit tests --coverage-html var/report
```