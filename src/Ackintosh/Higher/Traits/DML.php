<?php
namespace Ackintosh\Higher\Traits;

trait DML
{
    public function afterExecute($statement)
    {
        return null;
    }

    public function useSlave()
    {
        if (isset($this->useSlave)) {
            return $this->useSlave;
        }

        return false;
    }
}
