<?php
require_once __DIR__ . '/vendor/autoload.php';

$config = new Ackintosh\Higher\Config;

/**
 * Move config.yml.sample to config.yml
 */
$config->setConfigFile('config.yml')
    ->parse()
    ->setTableDir(__DIR__ . '/table');

$repo = new Ackintosh\Higher\Repository($config);

$users = $repo->get('users');
$orders = $repo->get('orders');

$res = $users
    ->select([
        [$users, 'name'],
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

