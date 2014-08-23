<?php
namespace Ackintosh\Higher\Query;

class Executor
{
    public function perform($builder)
    {
        list($sql, $values) = $builder->toString();
        $statement = $builder->getConnection()->prepare($sql);
        $statement->execute($values);

        return $builder->afterExecute($statement);
    }
}
