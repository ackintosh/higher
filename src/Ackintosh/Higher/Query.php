<?php
namespace Ackintosh\Higher;
use Ackintosh\Higher\Query\Builder;

class Query
{
    private $connectionManager;

    public function __construct($connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    public function select($columns)
    {
        return (new Builder($this->connectionManager))->select($columns);
    }

    public function insert($table, $columns)
    {
        return (new Builder($this->connectionManager))->insert($table, $columns);
    }

    public function upsert($table, $columns)
    {
        return (new Builder($this->connectionManager))->upsert($table, $columns);
    }

    public function update($table)
    {
        return (new Builder($this->connectionManager))->update($table);
    }

    /**
     * @params  Ackintosh\Higher\Record  $record
     * @return  Ackintosh\Higher\Record  $record
     */
    public function save($record)
    {
        $builder = (new Builder($this->connectionManager))
            ->upsert($record->getTable(), $record->getColumnNames())
            ->values($record->getValues());
        $builder->execute();

        if ($lastInsertId = $builder->getConnection()->lastInsertId()) {
            $record->setSequenceValue($lastInsertId);
        }

        return $record;
    }
}
