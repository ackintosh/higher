<?php
namespace Ackintosh\Higher\Traits;

trait DML
{
    /**
     * @var \Ackintosh\Higher\Table
     */
    private $table;

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

    private function setTable($table)
    {
        $this->table = $table;
    }

    public function getLocation()
    {
        return $this->table->getLocation();
    }
}
