<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Connection;

class ConnectionManager
{
    private $config;
    private $connections;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function get($location)
    {
        if (isset($this->connections[$location])) {
            return $this->connections[$location];
        }

        $this->connections[$location] = (new Connection(
            $this->config->getTableConnectionConfig($location)
        ))->setUp();

        return $this->connections[$location];
    }

    public function getEntityDir()
    {
        return $this->config->getEntityDir();
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->connection, $method], $args);
    }
}
