<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Connection;
use Ackintosh\Higher\Exceptions\TransactionException;

class ConnectionManager
{
    /**
     * @var Ackintosh\Higher\Config
     */
    private $config;

    /**
     * @var array
     */
    private $connections;

    /**
     * @var bool
     */
    private $beginTransaction = false;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @throws Ackintosh\Higher\Exceptions\TransactionException
     */
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

        $connection = (new Connection($param))->setUp();

        if ($this->beginTransaction === true && $connection->beginTransaction() === false) {
            throw TransactionException::beginFailed();
        }

        $this->connections[$location][$connectionKey] = $connection;

        return $this->connections[$location][$connectionKey];
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->connection, $method], $args);
    }

    public function begin()
    {
        $this->beginTransaction = true;
    }

    /**
     * @throws Ackintosh\Higher\Exceptions\TransactionException
     */
    public function commit()
    {
        foreach ($this->connections as $location) {
            foreach ($location as $conn) {
                if ($conn->commit() === false) {
                    throw TransactionException::commitFailed();
                }
            }
        }

        $this->resetTransaction();
    }

    /**
     * @throws Ackintosh\Higher\Exceptions\TransactionException
     */
    public function rollback()
    {
        foreach ($this->connections as $location) {
            foreach ($location as $conn) {
                if ($conn->rollBack() === false) {
                    throw TransactionException::rollbackFailed();
                }
            }
        }

        $this->resetTransaction();
    }

    private function resetTransaction()
    {
        $this->beginTransaction = false;
    }
}
