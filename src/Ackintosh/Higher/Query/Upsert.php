<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Interfaces\DML as DMLInterface;
use Ackintosh\Higher\Traits\DML;

class Upsert implements DMLInterface
{
    use DML;

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

    /**
     * @override \Ackintosh\Higher\Interfaces\DML::getSql()
     */
    public function getSql()
    {
        $sql = 'INSERT INTO `' . $this->table->getName() .'`';

        if ($this->columns) {
            $cols = array_map(function ($c) {
                return "`{$c}`";
            }, $this->columns);
            $sql .= ' ( ' . implode(',', $cols) . ' ) ';
        }

        $sql .= ' VALUES ( ' . implode(',', array_fill(0, count($this->values), '?')) . ' ) ';

        $updateArr = [];
        foreach ($this->columns as $col) {
            $updateArr[] = "`{$col}` = ?";
        }

        $sql .= 'ON DUPLICATE KEY UPDATE ' . implode(',', $updateArr);

        return $sql;
    }

    /**
     * @override \Ackintosh\Higher\Interfaces\DML::getValues()
     */
    public function getValues()
    {
        $values = $this->values;
        foreach ($this->values as $val) {
            $values[] = $val;
        }

        return $values;
    }

    public function getLocation()
    {
        return $this->table->getLocation();
    }
}

