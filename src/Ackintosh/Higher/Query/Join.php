<?php
namespace Ackintosh\Higher\Query;

class Join
{
    private $owner;
    private $target;
    private $on;

    public function __construct($owner, $target, Array $on)
    {
        $this->owner  = $owner;
        $this->target = $target;
        $this->on     = $on;
    }

    public function toString()
    {
        $str = 'INNER JOIN `' . $this->target->getName() . '`';
        $str .= sprintf(
            ' ON `%s`.`%s` = `%s`.`%s`',
            $this->owner->getName(),
            array_keys($this->on)[0],
            $this->target->getName(),
            array_values($this->on)[0]
        );

        return $str;
    }
}
