<?php
class Users extends Ackintosh\Higher\Table
{
    protected $location = 'db2';

    /**
     * @var array
     */
    protected $schema = [
        'id'        => ['int', 'sequence'],
        'name'      => ['varchar'],
        'created'   => ['datetime'],
        ];
}
