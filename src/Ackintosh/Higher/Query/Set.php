<?php
namespace Ackintosh\Higher\Query;

class Set
{
    private $params;

    public function __construct(Array $params)
    {
        $this->params = $params;
    }

    public function toString()
    {
        $str = ' SET ';

        $tmp = [];
        foreach ($this->params as $k => $v) {
            $tmp[] = "`{$k}` = ?";
        }
        $str .= implode(', ', $tmp);

        return $str;
    }

    public function getValues()
    {
        return array_values($this->params);
    }
}
