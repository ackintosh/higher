<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Join;
use Ackintosh\Higher\Query\ExpressionManager;

class Select
{
    private $owner;
    private $columns;
    private $joins;
    private $expressions;

    public function __construct($owner, $columns)
    {
        $this->owner = $owner;
        $this->columns = $columns;
        $this->joins = [];
        $this->expressions = [];
    }

    public function join($table, Array $on)
    {
        $this->joins[] = new Join($this->owner, $table, $on);

        return;
    }

    public function where()
    {
        $args = func_get_args();

        foreach ($args as $arg) {
            if (is_string($arg)) {
                $this->expressions[] = $arg;
                continue;
            }

            $expr = new ExpressionManager;
            call_user_func_array($arg, [$expr]);
            $this->expressions[] = $expr;
        }

        return;
    }

    public function toString()
    {
        $str = 'SELECT ';

        $columns = array_map(function ($col) {
            $tableName = array_shift($col)->getName();
            $ret = '';
            foreach ($col as $c) {
                $ret .= "`{$tableName}`.`{$c}`";
            }

            return $ret;
        }, $this->columns);

        $sql = $str . implode(',', $columns);

        $sql .= ' FROM `' . $this->owner->getName() . '`';

        foreach ($this->joins as $j) {
            $sql .= ' ' . $j->toString();
        }

        if (count($this->expressions) > 0) {
            $sql .= ' WHERE ';
        }
        $values = [];
        foreach ($this->expressions as $expr) {
            if (is_string($expr)) {
                $sql .= $expr;
                continue;
            }

            $sql .= ' ( ' . $expr->toString() . ' ) ';
            foreach ($expr->getValues() as $v) {
                $values[] = $v;
            }
        }

        return [$sql, $values];
    }
}
