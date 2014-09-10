<?php
use Ackintosh\Higher\Query\Upsert;
use Ackintosh\Higher\Table;

class UpsertTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructorSetsProperties()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];

        $upsert = new Upsert($table, $columns);

        $this->assertSame($table, TestHelper::getPrivateProperty($upsert, 'table'));
        $this->assertSame($columns, TestHelper::getPrivateProperty($upsert, 'columns'));
    }

    /**
     * @test
     */
    public function valuesSetsProperty()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];
        $upsert = new Upsert($table, $columns);
        $values = ['value1', 'value2'];
        $upsert->values($values);

        $this->assertSame($values, TestHelper::getPrivateProperty($upsert, 'values'));
    }

    /**
     * @test
     */
    public function getSql()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];
        $values = ['value1', 'value2'];
        $upsert = new Upsert($table, $columns);
        $upsert->values($values);
        $actual = $upsert->getSql();


        $expectSql = 'INSERT INTO `table` ( `test1`,`test2` )  VALUES ( ?,? ) ON DUPLICATE KEY UPDATE `test1` = ?,`test2` = ?';
        $this->assertSame($expectSql, $actual);
    }

    /**
     * @test
     */
    public function getValues()
    {
        $table = new Table;
        $columns = ['test1', 'test2'];
        $values = ['value1', 'value2'];
        $upsert = new Upsert($table, $columns);
        $upsert->values($values);
        $actual = $upsert->getValues();

        $expectValues = ['value1', 'value2', 'value1', 'value2'];
        $this->assertSame($expectValues, $actual);
    }
}
