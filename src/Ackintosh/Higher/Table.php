<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Query\Builder;

class Table
{
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

    public function getLocation()
    {
        return $this->location;
    }
}
