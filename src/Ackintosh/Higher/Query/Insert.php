<?php
namespace Ackintosh\Higher\Query;

class Insert
{
    private $table;
    private $columns;
    private $values;

    public function __construct($table, $columns)
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->values = [];
    }

    public function values(Array $values)
    {
        $this->values = $values;

        return;
    }

    public function toString()
    {
        $sql = 'INSERT INTO `' . $this->table->getName() .'`';

        if ($this->columns) {
            $cols = array_map(function ($c) {
                return "`{$c}`";
            }, $this->columns);
            $sql .= ' ( ' . implode(',', $cols) . ' ) ';
        }

        $sql .= ' VALUES ( ' . implode(',', array_fill(0, count($this->values), '?')) . ' ) ';

        return [$sql, $this->values];
    }

    public function getConnection()
    {
        return $this->table->getConnection();
    }
}

