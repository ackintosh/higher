<?php
namespace Ackintosh\Higher\Table;

class Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed
     */
    private $option;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($name, $type, $option)
    {
        $this->name     = $name;
        $this->type     = $type;
        $this->option   = $option;
    }

    /**
     * @return  void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return  mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isSequence()
    {
        return in_array('sequence', $this->option);
    }
}
