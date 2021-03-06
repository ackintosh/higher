Higher
---
[Work in progress]
Higher is a ORM library, written in PHP.

master : [![Build
Status](https://travis-ci.org/ackintosh/higher.svg?branch=master)](https://travis-ci.org/ackintosh/higher) [![Coverage Status](https://coveralls.io/repos/ackintosh/higher/badge.png?branch=develop)](https://coveralls.io/r/ackintosh/higher?branch=master)

develop : [![Build Status](https://travis-ci.org/ackintosh/higher.svg?branch=develop)](https://travis-ci.org/ackintosh/higher) [![Coverage Status](https://coveralls.io/repos/ackintosh/higher/badge.png?branch=develop)](https://coveralls.io/r/ackintosh/higher?branch=develop)


## Description
Named "Higher" was inspired by this song. (｢ﾟДﾟ)｢ gow gow

[![MAN WITH A MISSION : higher](http://img.youtube.com/vi/RIBqsb5yIx8/0.jpg)](https://www.youtube.com/watch?v=RIBqsb5yIx8)

## Requirement
PHP 5.4 or higher

## Usage
```php
<?php
$config = (new Ackintosh\Higher\Config())
    ->setConfigFile('config.yml')
    ->parse()
    ->setTableDir(__DIR__ . '/table');

$repo = new Ackintosh\Higher\Repository($config);
$connectionManager = new Ackintosh\Higher\ConnectionManager($config);
$query = new Ackintosh\Higher\Query($connectionManager);

$users = $repo->get('users');
$orders = $repo->get('orders');
```

### SELECT
```php
$res = $query->select([
        [$users, 'name', 'addr'],
        [$orders, 'total'],
    ])
    ->from($users)
    ->join($orders, ['id' => 'user_id'])
    ->where(
        function ($expr) use ($users, $orders) {
            $expr->_($users, ['id', '=', 2]);
            $expr->_or($users, ['id', '=', 3]);
        },
        'AND',
        function ($expr) use ($users, $orders) {
            $expr->_($users, ['id', '=', 2]);
            $expr->_or($users, ['id', '=', 3]);
        }
        )
    ->useMaster()// use the master DB explicitly.
    ->execute();
```

```sql
SELECT
`users`.`name` as `users.name`,
`users`.`addr` as `users.addr`,
`orders`.`total` as `orders.total`
FROM
`users`
INNER JOIN `orders`
ON `users`.`id` = `orders`.`user_id`
WHERE
(  `users`.`id` = ? OR `users`.`id` = ? )
AND
(  `users`.`id` = ? OR `users`.`id` = ? )
```

### INSERT
```php
<?php
$connectionManager->begin();

$res = $query->insert($users, ['name', 'created'])
    ->values(['testname', date('Y-m-d H:i:s')])
    ->execute();

$connectionManager->commit();
```

```sql
INSERT INTO `users` ( `name`,`created` )  VALUES ( ?,? )
```

### UPSERT
```php
<?php
$connectionManager->begin();

$res = $query->upsert($users, ['name', 'created'])
    ->values(['testname', date('Y-m-d H:i:s')])
    ->execute();

$connectionManager->commit();
```

```sql
INSERT INTO `users` ( `name`,`created` )  VALUES ( ?,? ) ON DULPLICATE KEY UPDATE `name` = ?,`created` = ?
```
### UPDATE
```php
<?php
$ret = $query->update($users)
    ->set(['name' => 'foo', 'addr' => 'bar'])
    ->where(
        function ($expr) use ($users) {
            $expr->_($users, ['id', '=', 2]);
        }
    )->execute();

```

```sql
UPDATE users  SET `name` = ?, `addr` = ? WHERE  (  `users`.`id` = ? )
```

### OTHER
```php
<?php
$u = $users->newRecord();
$u->name = 'foo';
$u->created = date('Y-m-d H:i:s');
$query->save($u); // insert

$u->name = 'bar';
$query->save($u); // update
```



## Install

```composer.json
{
  "require": {
    "ackintosh/higher": "*"
  }
}
```

```shell
$ php composer.phar install
```

## Contribution

## Licence

## Author

[Akihito Nakano](https://github.com/ackintosh)

