<?php
namespace Ackintosh\Higher\Table;
use Ackintosh\Higher\Table\Column;
use Ackintosh\Higher\Exceptions\TableException;

class Record
{
    /**
     * @var Ackintosh\Higher\Table
     */
    private $table;

    /**
     * @var array
     */
    private $columns = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function setColumns($schema)
    {
        foreach ($schema as $col => $s) {
            $this->columns[$col] = new Column($col, array_shift($s), $s);
        }
    }

    /**
     * @throws \Ackintosh\Higher\Exceptions\TableException
     */
    public function __set($name, $value)
    {
        if (!in_array($name, array_keys($this->columns))) {
            throw TableException::columnDoesNotExists($name, $this->table->getName());
        }
        $this->columns[$name]->setValue($value);
    }

    /**
     * @throws RuntimeException
     */
    public function __get($name)
    {
        if (!in_array($name, array_keys($this->columns))) {
            throw new \RuntimeException();
        }

        return $this->columns[$name]->getValue();
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getColumnNames()
    {
        return array_keys($this->columns);
    }

    public function getValues()
    {
        $ret = [];
        foreach ($this->columns as $c) {
            $ret[] = $c->getValue();
        }

        return $ret;
    }

    public function setSequenceValue($value)
    {
        foreach ($this->columns as $c) {
            if ($c->isSequence()) {
                $c->setValue($value);
            }
        }
    }
}
