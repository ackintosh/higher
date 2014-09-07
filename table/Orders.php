<?php
use Ackintosh\Higher\Table;

class Orders extends Table
{
    protected $location = 'db2';

    /**
     * @var array
     */
    protected $schema = [
        'id'        => ['int', 'sequence'],
        'user_id'   => ['int'],
        'total'     => ['int'],
        'created'   => ['datetime'],
        ];
}
