<?php
namespace Ackintosh\Higher\Exceptions;

class TransactionException extends RuntimeException
{
    /**
     * @return Ackintosh\Higher\Exception\TransactionException
     */
    public static function beginFailed()
    {
        return new self('beginTransaction failed.');
    }

    /**
     * @return Ackintosh\Higher\Exception\TransactionException
     */
    public static function commitFailed()
    {
        return new self('commit failed.');
    }

    /**
     * @return Ackintosh\Higher\Exception\TransactionException
     */
    public static function rollbackFailed()
    {
        return new self('rollback failed.');
    }
}
