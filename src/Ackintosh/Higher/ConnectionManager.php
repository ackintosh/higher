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

    public function get($location, $useSlave = false)
    {
        // If we have no configuration for slave,
        // ConnectionManager uses master connection.
        if ($useSlave === true && count($this->config->getConnectionConfig($location, 'slaves')) === 0 ) {
            $useSlave = false;
        }

        if ($useSlave === false) {
            $param = $this->config->getConnectionConfig($location);
            $connectionKey = 'master';
        } else {
            $params = $this->config->getConnectionConfig($location, 'slaves');
            $slaveKey = array_rand($params);
            $param = $params[$slaveKey];
            $connectionKey = 'slave' . $slaveKey;
        }

        if (isset($this->connections[$location][$connectionKey])) {
            return $this->connections[$location][$connectionKey];
        }

        $this->connections[$location][$connectionKey] = (new Connection($param))->setUp();

        return $this->connections[$location][$connectionKey];
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
