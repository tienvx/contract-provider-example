# contract-provider-example

```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
php bin/console hautelook:fixtures:load
symfony serve
PACT_BROKER_URI="http://localhost:58000" PACT_BROKER_BEARER_TOKEN="xxxxxxxxxxxxx" php vendor/bin/codecept run
```
