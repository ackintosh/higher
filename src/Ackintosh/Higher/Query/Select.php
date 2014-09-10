<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Join;
use Ackintosh\Higher\Query\Expression\ExpressionUnit;
use Ackintosh\Higher\Interfaces\DML as DMLInterface;
use Ackintosh\Higher\Traits\DML;
use Ackintosh\Higher\Traits\Selectable;

class Select implements DMLInterface
{
    use DML, Selectable;

    /**
     * @see DML::useSlave()
     */
    protected $useSlave = true;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var array
     */
    private $joins;

    public function __construct($columns)
    {
        $this->columns = $columns;
        $this->joins = [];
    }

    public function from($table)
    {
        $this->setTable($table);
    }

    public function join($table, Array $on)
    {
        $this->joins[] = new Join($this->table, $table, $on);
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
        $sql .= ' FROM `' . $this->table->getName() . '`';

        foreach ($this->joins as $j) {
            $sql .= ' ' . $j->toString();
        }

        $sql .= $this->where->toString();

        return $sql;
    }

    /**
     * @override \Ackintosh\Higher\Interfaces\DML::getValues()
     */
    public function getValues()
    {
        return $this->where->getValues();
    }

    /**
     * @override    \Ackintosh\Higher\Traits\DML::afterExecute($statement)
     */
    public function afterExecute($statement)
    {
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
