<?php
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Move config.yml.sample to config.yml
 */
$config = (new Ackintosh\Higher\Config())
    ->parse()
    ->setTableDir(__DIR__ . '/table');

$repo = new Ackintosh\Higher\Repository($config);
$connectionManager = new Ackintosh\Higher\ConnectionManager($config);
$query = new Ackintosh\Higher\Query($connectionManager);

$users = $repo->get('users');
$orders = $repo->get('orders');

$ret = $query->select([
        [$users, 'name', 'addr'],
        [$orders, 'total'],
    ])
    ->join($orders, ['id' => 'user_id'])
    ->where(
        function ($expr) use ($users, $orders) {
            $expr->_and($users, ['id', '=', 2]);
            $expr->_or($users, ['id', '=', 3]);
        },
        'AND',
        function ($expr) use ($users, $orders) {
            $expr->_and($users, ['id', '=', 2]);
            $expr->_or($users, ['id', '=', 3]);
        }
        )
    ->useMaster()// use the master DB explicitly.
    ->execute();

/**
 * SELECT
 * `users`.`name`,
 * `users`.`addr`,
 * `orders`.`total`
 * FROM
 * `users`
 * INNER JOIN `orders`
 * ON `users`.`id` = `orders`.`user_id`
 * WHERE
 * (  `users`.`id` = ? OR `users`.`id` = ? )
 * AND
 * (  `users`.`id` = ? OR `users`.`id` = ? )
 */


$ret = $query->insert($users, ['name', 'created'])
    ->values(['testname', date('Y-m-d H:i:s')])
    ->execute();

/**
 * INSERT INTO `users` ( `name`,`created` )  VALUES ( ?,? )
 */
