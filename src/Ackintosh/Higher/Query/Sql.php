<?php
namespace Ackintosh\Higher\Query;

class Sql
{
    /**
     * @var string
     */
    private $sql;

    /**
     * @var array
     */
    private $values;

    public function __construct($sql, $values)
    {
        $this->sql = $sql;
        $this->values = $values;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function getValues()
    {
        return $this->values;
    }
}
