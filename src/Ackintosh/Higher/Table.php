<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Query\Builder;

class Table
{
    /**
     * @var Ackintosh\Higher\Connection
     */
    private $conn;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $location;

    public function __construct()
    {
        if (empty($this->name)) {
            $classNameParts = explode('\\', get_called_class());
            $this->name = ltrim(
                strtolower(preg_replace('/([A-Z])/', '_$1',  array_pop($classNameParts))),
                '_');
        }

        if (empty($this->location)) {
            $this->location = 'default';
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setConnection($conn)
    {
        $this->conn = $conn;

        return $this;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function getLocation()
    {
        return $this->location;
    }

    /**
     *
     * @params  string          $sql
     * @return  PDO::Statement
     */
    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }
}
