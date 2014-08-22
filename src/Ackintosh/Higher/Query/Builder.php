<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Select;

class Builder
{
    /**
     * @var 
     */
    private $main;

    /**
     * @var array
     */
    private $columns;

    public function __construct()
    {
    }

    public function select($columns)
    {
        $this->main = new Select($columns);

        return $this;
    }

    public function from($from)
    {
        $this->main->from($from);

        return $this;
    }

    public function join($table, Array $on)
    {
        $this->main->join($table, $on);

        return $this;
    }

    public function insert($table, $columns)
    {
        $this->main = new Insert($table, $columns);

        return $this;
    }

    public function values(Array $values)
    {
        $this->main->values($values);

        return $this;
    }

    public function execute()
    {
        return $this->main->execute();
    }

    public function where()
    {
        call_user_func_array([$this->main, 'where'], func_get_args());

        return $this;
    }
}
