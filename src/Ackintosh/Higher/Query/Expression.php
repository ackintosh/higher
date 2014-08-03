<?php
namespace Ackintosh\Higher\Query;

abstract class Expression
{
    protected $table;
    protected $column;
    protected $value;
    protected $pre;

    public function __construct($table, $params)
    {
        $this->table    = $table;
        $this->column   = $params[0];
        $this->expr     = $params[1];
        $this->value    = $params[2];
    }

    public function toString()
    {
        return sprintf(
            "{$this->pre} `%s`.`%s` {$this->expr} ?",
            $this->table->getName(),
            $this->column);
    }

    public function getValue()
    {
        return $this->value;
    }
}
