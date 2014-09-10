<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Join;
use Ackintosh\Higher\Query\Set;
use Ackintosh\Higher\Query\Expression\Manager;
use Ackintosh\Higher\Interfaces\DML as DMLInterface;
use Ackintosh\Higher\Traits\DML;
use Ackintosh\Higher\Traits\Selectable;

class Update implements DMLInterface
{
    use DML, Selectable;

    /**
     * @var \Ackintosh\Higher\Query\Set
     */
    private $set;

    public function __construct($table)
    {
        $this->setTable($table);
    }

    public function set(Array $params)
    {
        $this->set = new Set($params);
        return $this;
    }

    /**
     * @override \Ackintosh\Higher\Interfaces\DML::getSql()
     */
    public function getSql()
    {
        $sql = 'UPDATE ' . $this->table->getName() . ' ';
        $sql .= $this->set->toString();
        if ($this->where) {
            $sql .= $this->where->toString();
        }

        return $sql;
    }

    /**
     * @override \Ackintosh\Higher\Interfaces\DML::getValues()
     */
    public function getValues()
    {
        $values = array_merge($this->set->getValues(), $this->where->getValues());
        return $values;
    }
}
