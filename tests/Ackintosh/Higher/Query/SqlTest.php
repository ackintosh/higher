<?php
use Ackintosh\Higher\Query\Sql;

class SqlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructor()
    {
        $str = 'foo';
        $val = [1, 2, 3];
        $sql = new Sql($str, $val);

        $this->assertSame($str, TestHelper::getPrivateProperty($sql, 'sql'), '-> sets string to its "sql" property.');
        $this->assertSame($val, TestHelper::getPrivateProperty($sql, 'values'), '-> sets array to its "values" property.');
    }

    /**
     * @test
     */
    public function getSql()
    {
        $str = 'foo';
        $val = [1, 2, 3];
        $sql = new Sql($str, $val);

        $this->assertSame($str, $sql->getSql(), '-> returns the string.');
    }

    /**
     * @test
     */
    public function getValues()
    {
        $str = 'foo';
        $val = [1, 2, 3];
        $sql = new Sql($str, $val);

        $this->assertSame($val, $sql->getValues(), '-> returns the array.');
    }
}

