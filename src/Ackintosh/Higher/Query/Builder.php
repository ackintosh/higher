<?php
namespace Ackintosh\Higher\Query;
use Ackintosh\Higher\Query\Select;
use Ackintosh\Higher\Query\Insert;
use Ackintosh\Higher\Query\Upsert;
use Ackintosh\Higher\Query\Executor;

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

    /**
     * @var Ackintosh\Higher\ConnectionManager
     */
    private $connectionManager;

    /**
     * @var bool
     */
    private $useMasterExplicitly = false;

    public function __construct($connectionManager)
    {
        $this->connectionManager = $connectionManager;
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

    public function upsert($table, $columns)
    {
        $this->main = new Upsert($table, $columns);

        return $this;
    }

    public function values(Array $values)
    {
        $this->main->values($values);

        return $this;
    }

    public function useMaster()
    {
        $this->useMasterExplicitly = true;

        return $this;
    }

    public function execute()
    {
        $executor = new Executor;
        return $executor->perform($this);
    }

    public function where()
    {
        call_user_func_array([$this->main, 'where'], func_get_args());

        return $this;
    }

    public function toString()
    {
        return $this->main->toString();
    }

    public function getConnection()
    {
        $useSlave = ($this->useMasterExplicitly === true) ? false : $this->main->useSlave();
        return $this->connectionManager->get($this->main->getLocation(), $useSlave);
    }

    public function afterExecute($statement)
    {
        return $this->main->afterExecute($statement);
    }
}
