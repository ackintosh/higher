<?php
namespace Ackintosh\Higher\Query;

class Insert
{
    private $owner;
    private $columns;
    private $values;

    public function __construct($owner, $columns)
    {
        $this->owner = $owner;
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
        $sql = 'INSERT INTO `' . $this->owner->getName() .'`';

        if ($this->columns) {
            $cols = array_map(function ($c) {
                return "`{$c}`";
            }, $this->columns);
            $sql .= ' ( ' . implode(',', $cols) . ' ) ';
        }

        $sql .= ' VALUES ( ' . implode(',', array_fill(0, count($this->values), '?')) . ' ) ';

        return [$sql, $this->values];
    }

    /**
     *
     * @params  string          $sql
     * @return  PDO::Statement
     */
    public function prepare($sql)
    {
        return $this->owner->prepare($sql);
    }

    public function execute()
    {
        list($sql, $values) = $this->toString();

        $statement = $this->prepare($sql);
        if ($statement === false) {
            // TODO: error handling
        }
        return $statement->execute($values);
    }
}

