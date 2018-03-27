### Создание сущностей из существующих таблиц базы данных

```php
php bin/console doctrine:mapping:import
```

> не работает без явного указания Bundle в аргументах!!!
> В Symfony 4 не работает!!!

##### 1. Обходной путь

 Обходным путем является временное создание пакета. См. [doctrine/doctrine#729](https://github.com/doctrine/DoctrineBundle/issues/729) . Более того, эта функция для создания сущностей из существующих баз данных будет полностью удалена в следующей версии Doctrine.
 
 
##### 2. Обходной путь

```php
$> php bin/console doctrine:mapping:convert --namespace="App\Entity\\" --filter="\\Categories$" --force --from-database annotation src/Entity
$> php bin/console doctrine:generate:entities App/Entity --no-backup
```

Далее ручками переносим из `src/Entity/App/Entity` все сущности в `src/Entity`
