# Shift Manager

```shell script
docker-compose exec app composer install
docker-compose exec app bin/console make:migration
docker-compose exec app bin/console doctrine:migrations:migrate --no-interaction
```