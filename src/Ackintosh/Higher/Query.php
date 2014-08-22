<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Query\Builder;

class Query
{
    public static function select($columns)
    {
        return (new Builder())->select($columns);
    }

    public static function insert($table, $columns)
    {
        return (new Builder())->insert($table, $columns);
    }
}
