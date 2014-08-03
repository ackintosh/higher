<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Join;
use Ackintosh\Higher\Query\Expression;
use Ackintosh\Higher\Query\Select;

class Builder
{
    /**
     * @var Ackintosh\Higher\Table
     */
    private $owner;

    /**
     * @var 
     */
    private $main;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var array(Ackintosh\Higher\Query\Join)
     */
    private $join;

    /**
     * @var array(Ackintosh\Higher\Query\ExpressionManager)
     */
    private $expressions;

    public function __construct($table)
    {
        $this->owner = $table;
        $this->join = [];
        $this->expressions = [];
    }

    public function select($columns)
    {
        $this->main = new Select($columns);

        return $this;
    }

    public function join($table, Array $on)
    {
        $this->join[] = new Join($this->owner, $table, $on);
        return $this;
    }

    public function execute()
    {
        $sql = $this->main->toString();
        $sql .= ' FROM `' . $this->owner->getName() . '`';

        foreach ($this->join as $j) {
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

var_dump($sql, $values);
        return $this->owner->query($sql, $values);
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

        return $this;
    }
}
