<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\ConnectionManager;

class Repository
{
    /**
     * @var Ackintosh\Higher\Config
     */
    private $config;

    private $connectionManager;

    public function __construct($config)
    {
        $this->config = $config;
        $this->connectionManager = new ConnectionManager($config);
    }

    public function get($table)
    {
        return $this->instantiateTable($table);
    }

    public function instantiateTable($tableName)
    {
        $s = array_map(function ($part) {
            return ucfirst($part);
        }, explode('_', $tableName));
        $tableClassName = implode('', $s);

        require_once($this->config->getTableDir() . "/{$tableClassName}.php");
        $table = new $tableClassName;

        $connection = $this->connectionManager->get($table->getLocation());
        $table->setConnection($connection);

        return $table;
    }

    public function beginTransaction()
    {
    }

    public function commit()
    {
    }

    public function rollback()
    {
    }
}
