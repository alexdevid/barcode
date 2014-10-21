barcode
=======

* создать папки `assets` и `protected/runtime` с правами на запись
* создать `protected/config/db.php`

```php
<?php
return array (
  'connectionString' => 'mysql:host=localhost;dbname=barcode',
  'emulatePrepare' => true,
  'username' => 'root',
  'password' => '',
  'charset' => 'utf8',
  'tablePrefix' => 'bc_',
);
```

* миграции protected/yiic migrate