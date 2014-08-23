<?php
namespace Ackintosh\Higher\Traits;

trait Expression
{
    protected $table;
    protected $column;
    protected $expr;
    protected $value;

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
