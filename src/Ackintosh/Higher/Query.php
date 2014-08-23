<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Query\Builder;

class Query
{
    private $connectionManager;

    public function __construct($connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    public function select($columns)
    {
        return (new Builder($this->connectionManager))->select($columns);
    }

    public function insert($table, $columns)
    {
        return (new Builder($this->connectionManager))->insert($table, $columns);
    }
}
