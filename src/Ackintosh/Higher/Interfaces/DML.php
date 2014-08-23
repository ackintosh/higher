<?php
namespace Ackintosh\Higher\Interfaces;

interface DML
{
    public function afterExecute($statement);
}
