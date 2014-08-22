<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Join;
use Ackintosh\Higher\Query\ExpressionManager;

class Select
{
    private $columns;

    /**
     * @var Ackintosh\Higher\Table
     */
    private $from;

    private $joins;
    private $expressions;

    public function __construct($columns)
    {
        $this->columns = $columns;
        $this->joins = [];
        $this->expressions = [];
    }

    public function from($table)
    {
        $this->from = $table;
    }

    public function join($table, Array $on)
    {
        $this->joins[] = new Join($this->from, $table, $on);

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
            $ret = [];
            foreach ($col as $c) {
                $ret[] = "`{$tableName}`.`{$c}`";
            }

            return implode(',', $ret);
        }, $this->columns);

        $sql = $str . implode(',', $columns);

        $sql .= ' FROM `' . $this->from->getName() . '`';

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

    /**
     *
     * @params  string          $sql
     * @return  PDO::Statement
     */
    public function prepare($sql)
    {
        return $this->from->prepare($sql);
    }

    public function execute()
    {
        list($sql, $values) = $this->toString();

        $statement = $this->prepare($sql);
        if ($statement === false) {
            // TODO: error handling
        }
        $statement->execute($values);

        return $statement->fetchAll();
    }
}
