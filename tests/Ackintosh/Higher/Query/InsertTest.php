<?php
use Ackintosh\Higher\Query\Insert;
use Ackintosh\Higher\Table;

class InsertTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructorSetsProperties()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];

        $insert = new Insert($table, $columns);

        $this->assertSame($table, TestHelper::getPrivateProperty($insert, 'table'));
        $this->assertSame($columns, TestHelper::getPrivateProperty($insert, 'columns'));
    }

    /**
     * @test
     */
    public function valuesSetsProperty()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];
        $insert = new Insert($table, $columns);
        $values = ['value1', 'value2'];
        $insert->values($values);

        $this->assertSame($values, TestHelper::getPrivateProperty($insert, 'values'));
    }

    /**
     */
    public function toString()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];
        $values = ['value1', 'value2'];
        $insert = new Insert($table, $columns);
        $insert->values($values);
        $ret = $insert->toString();

        $this->assertSame(2, count($ret));
        $expectSql = 'INSERT INTO `table` ( `test1`,`test2` )  VALUES ( ?,? ) ';
        $this->assertSame($expectSql, $ret[0]);
        $this->assertSame($values, $ret[1]);
    }

    /**
     * @test
     */
    public function getSql()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];
        $values = ['value1', 'value2'];
        $insert = new Insert($table, $columns);
        $insert->values($values);
        $sql = $insert->getSql();

        $expectSql = 'INSERT INTO `table` ( `test1`,`test2` )  VALUES ( ?,? ) ';
        $this->assertSame($expectSql, $sql);
    }

    /**
     * @test
     */
    public function getValues()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];
        $values = ['value1', 'value2'];
        $insert = new Insert($table, $columns);
        $insert->values($values);
        $actual = $insert->getValues();

        $this->assertSame($values, $actual);
    }
}
