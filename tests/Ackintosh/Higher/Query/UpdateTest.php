<?php
use Ackintosh\Higher\Query\Update;
use Ackintosh\Higher\Table;

class UpdateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructor()
    {
        $table = new Table;
        $update = new Update($table);

        $this->assertSame($table, TestHelper::getPrivateProperty($update, 'table'), '-> sets "Table" object to "table" property.');
    }

    /**
     * @test
     */
    public function set()
    {
        $table = new Table;
        $update = new Update($table);
        $params = ['foo' => 123, 'bar' => 456];
        $update->set($params);

        $this->assertInstanceOf('\Ackintosh\Higher\Query\Set', TestHelper::getPrivateProperty($update, 'set'), '-> sets "Set" object to "set" property.');
    }

    /**
     * @test
     */
    public function getSql()
    {
        $table = new Table;
        $update = new Update($table);
        $params = ['foo' => 123, 'bar' => 456];
        $update->set($params);
        $update->where(
            function ($expr) use ($table) {
                $expr->_($table, ['id', '=', 2]);
            });
        $actual = $update->getSql();
        $expect = 'UPDATE table  SET `foo` = ?, `bar` = ? WHERE  (  `table`.`id` = ? ) ';

        $this->assertSame($expect, $actual, '-> returns the sql string that built by itself.');
    }

    /**
     * @test
     */
    public function getValues()
    {
        $table = new Table;
        $update = new Update($table);
        $params = ['foo' => 123, 'bar' => 456];
        $update->set($params);
        $update->where(
            function ($expr) use ($table) {
                $expr->_($table, ['id', '=', 2]);
            });
        $actual = $update->getValues();
        $expect = [123, 456, 2];

        $this->assertSame($expect, $actual, '-> returns the values what needed to execute sql.');
    }
}
