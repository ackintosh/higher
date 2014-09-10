<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Query\Builder;
use Ackintosh\Higher\Table\Record;

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

    /**
     * @var array
     *
     * [
     *  'id'        => ['int', 'sequence'],
     *  'name'      => ['varchar'],
     *  'created'   => ['datetime'],
     * ]
     */
    protected $schema = [];

    /**
     * @var array
     */
    protected $columns = [];

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

    public function newRecord()
    {
        $r = new Record($this);
        $r->setColumns($this->schema);

        return $r;
    }
}
