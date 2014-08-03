<?php
namespace Ackintosh\Higher\Query;

class Select
{
    private $columns;

    public function __construct($columns) {
        $this->columns = $columns;
    }

    public function toString()
    {
        $str = 'SELECT ';

        $columns = array_map(function ($col) {
            $tableName = array_shift($col)->getName();
            $ret = '';
            foreach ($col as $c) {
                $ret .= "`{$tableName}`.`{$c}`";
            }

            return $ret;
        }, $this->columns);

        return $str . implode(',', $columns);
    }
}
