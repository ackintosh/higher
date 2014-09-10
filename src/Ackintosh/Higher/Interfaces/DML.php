<?php
namespace Ackintosh\Higher\Interfaces;

interface DML
{
    public function afterExecute($statement);
    public function getSql();
    public function getValues();
    public function getLocation();
}
