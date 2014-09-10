<?php
namespace Ackintosh\Higher\Traits;
use Ackintosh\Higher\Query\Where;

trait Selectable
{
    /**
     * @var \Ackintosh\Higher\Query\Where
     */
    private $where;

    public function where()
    {
        $args = func_get_args();
        $this->where = new Where($args);

        return $this;
    }
}
