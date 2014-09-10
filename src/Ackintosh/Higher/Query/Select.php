<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Join;
use Ackintosh\Higher\Query\Expression\Manager;
use Ackintosh\Higher\Interfaces\DML as DMLInterface;
use Ackintosh\Higher\Traits\DML;

class Select implements DMLInterface
{
    use DML;

    /**
     * @see DML::useSlave()
     */
    protected $useSlave = true;

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

            $expr = new Manager;
            call_user_func_array($arg, [$expr]);
            $this->expressions[] = $expr;
        }

        return;
    }

    /**
     * @override \Ackintosh\Higher\Interfaces\DML::getSql()
     */
    public function getSql()
    {
        $str = 'SELECT ';

        $columns = array_map(function ($col) {
            $tableName = array_shift($col)->getName();
            $ret = [];
            foreach ($col as $c) {
                $ret[] = "`{$tableName}`.`{$c}` as `{$tableName}.{$c}`";
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

        foreach ($this->expressions as $expr) {
            if (is_string($expr)) {
                $sql .= $expr;
                continue;
            }

            $sql .= ' ( ' . $expr->toString() . ' ) ';
        }

        return $sql;
    }

    /**
     * @override \Ackintosh\Higher\Interfaces\DML::getValues()
     */
    public function getValues()
    {
        $values = [];
        foreach ($this->expressions as $expr) {
            if (is_string($expr)) {
                continue;
            }

            foreach ($expr->getValues() as $v) {
                $values[] = $v;
            }
        }

        return $values;
    }

    public function getLocation()
    {
        return $this->from->getLocation();
    }

    /**
     * @override    DML::afterExecute($statement)
     */
    public function afterExecute($statement)
    {
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
