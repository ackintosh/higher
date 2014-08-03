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

    public function getLocation()
    {
        return $this->location;
    }

    public function select($columns)
    {
        return (new Builder($this))->select($columns);
    }

    public function query($sql, $values)
    {
        //var_dump($sql);
        $statement = $this->conn->prepare($sql);
        if ($statement === false) {
            // TODO: error handling
        }
        $statement->execute($values);

        return $statement->fetchAll();
    }
}
