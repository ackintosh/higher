Higher
---
[Work in progress]
Higher is a ORM library, written in PHP.

master : [![Build Status](https://travis-ci.org/ackintosh/higher.svg?branch=master)](https://travis-ci.org/ackintosh/higher)

develop : [![Build Status](https://travis-ci.org/ackintosh/higher.svg?branch=develop)](https://travis-ci.org/ackintosh/higher)

## Description
Named "Higher" was inspired by this song. (｢ﾟДﾟ)｢ｶﾞｳｶﾞｳ

[![MAN WITH A MISSION : higher](http://img.youtube.com/vi/RIBqsb5yIx8/0.jpg)](https://www.youtube.com/watch?v=RIBqsb5yIx8)

## Requirement

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
    ->execute();
```

```sql
SELECT
`users`.`name`,
`users`.`addr`,
`orders`.`total`
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
$res = $query->insert($users, ['name', 'created'])
    ->values(['testname', date('Y-m-d H:i:s')])
    ->execute();
```

```sql
INSERT INTO `users` ( `name`,`created` )  VALUES ( ?,? )
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

