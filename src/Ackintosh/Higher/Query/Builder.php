<?php
namespace Ackintosh\Higher\Query;
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

    public function __construct($table)
    {
        $this->owner = $table;
    }

    public function select($columns)
    {
        $this->main = new Select($this->owner, $columns);

        return $this;
    }

    public function join($table, Array $on)
    {
        $this->main->join($table, $on);

        return $this;
    }

    public function insert($columns)
    {
        $this->main = new Insert($this->owner, $columns);

        return $this;
    }

    public function values(Array $values)
    {
        $this->main->values($values);

        return $this;
    }

    public function execute()
    {
        list($sql, $values) = $this->main->toString();

        return $this->owner->query($sql, $values);
    }

    public function where()
    {
        call_user_func_array([$this->main, 'where'], func_get_args());

        return $this;
    }
}
