<?php
namespace Ackintosh\Higher\Query;

class Executor
{
    public function perform($builder)
    {
        list($sql, $values) = $builder->toString();
        $statement = $builder->getConnection()->prepare($sql);
        if ($statement === false) {
            // TODO: error handling
        }
        $statement->execute($values);
        return $statement->fetchAll();
    }
}
