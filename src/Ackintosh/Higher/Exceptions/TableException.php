<?php
namespace Ackintosh\Higher\Exceptions;

class TableException extends \LogicException
{
    /**
     * @return \Ackintosh\Higher\Exception\TableException
     */
    public static function columnDoesNotExists($name, $table)
    {
        return new self("There is no column with name '{$name}' on table {$table}.");
    }
}
