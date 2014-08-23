<?php
namespace Ackintosh\Higher;

class Repository
{
    /**
     * @var Ackintosh\Higher\Config
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function get($table)
    {
        return $this->instantiateTable($table);
    }

    private function instantiateTable($tableName)
    {
        $tableClassName = $this->getClassName($tableName);

        require_once($this->config->getTableDir() . "/{$tableClassName}.php");
        $table = new $tableClassName;

        return $table;
    }

    private function getClassName($tableName)
    {
        $s = array_map(function ($part) {
            return ucfirst($part);
        }, explode('_', $tableName));

        $tableClassName = implode('', $s);

        return $tableClassName;
    }
}
