<?php
namespace Ackintosh\Higher\Query;

class Executor
{
    public function perform($builder)
    {
        $sql = $builder->getSql();
        $statement = $builder->getConnection()->prepare($sql->getSql());
        $statement->execute($sql->getValues());

        return $builder->afterExecute($statement);
    }
}
