<?php
use Ackintosh\Higher\Table\Record;
use Ackintosh\Higher\Table;

class RecordTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructorSetsProperty()
    {
        $table = new Table();
        $record = new Record($table);
        $this->assertSame($table, TestHelper::getPrivateProperty($record, 'table'), '-> sets the Talbe object.');
    }

    /**
     * @test
     */
    public function setColumns()
    {
        $table = new Table();
        $schema = [
            'id'        => ['int', 'sequence'],
            'name'      => ['varchar'],
            'created'   => ['datetime'],
            ];
        $record = new Record($table);
        $record->setColumns($schema);
        $columns = TestHelper::getPrivateProperty($record, 'columns');

        $this->assertSame(count($schema), count($columns), '-> sets number of columns the same as the schema information.');
        $this->assertSame(array_keys($schema), $record->getColumnNames(), '-> sets the column that has been defined in schema information.');
    }

    /**
     * @test
     */
    public function set()
    {
        $table = new Table();
        $schema = [
            'id'        => ['int', 'sequence'],
            'name'      => ['varchar'],
            'created'   => ['datetime'],
            ];
        $record = new Record($table);
        $record->setColumns($schema);

        $name = 'testname';
        $record->name = $name;

        $this->assertSame($name, $record->name, '-> __set() sets value of column object.');
    }

    /**
     * @test
     * @expectedException \Ackintosh\Higher\Exceptions\TableException
     */
    public function setThrowsException()
    {
        $table = new Table();
        $record = new Record($table);
        $record->foo = 'foo';
    }

    /**
     * @test
     * @expectedException \Ackintosh\Higher\Exceptions\TableException
     */
    public function getThrowsException()
    {
        $table = new Table();
        $schema = [
            'id'        => ['int', 'sequence'],
            'name'      => ['varchar'],
            'created'   => ['datetime'],
            ];
        $record = new Record($table);
        $record->setColumns($schema);

        $record->foo = 123;
    }

    /**
     * @test
     */
    public function getTable()
    {
        $table = new Table();
        $record = new Record($table);
        $this->assertSame($table, $record->getTable(), '-> returns the Table object.');
    }

    /**
     * @test
     */
    public function getColumnNames()
    {
        $table = new Table();
        $schema = [
            'id'        => ['int', 'sequence'],
            'name'      => ['varchar'],
            'created'   => ['datetime'],
            ];
        $record = new Record($table);
        $record->setColumns($schema);
        $this->assertSame(array_keys($schema), $record->getColumnNames(), '-> returns the column names');
    }

    /**
     * @test
     */
    public function getValues()
    {
        $table = new Table();
        $schema = [
            'id'        => ['int', 'sequence'],
            'name'      => ['varchar'],
            'created'   => ['datetime'],
            ];
        $record = new Record($table);
        $record->setColumns($schema);
        $values = [99, 'foo', '2000-01-01 00:00:00'];
        $record->id         = $values[0];
        $record->name       = $values[1];
        $record->created    = $values[2];

        $this->assertSame($values, $record->getValues(), '-> returns the values that the record has.');
    }

    /**
     * @test
     */
    public function setSequenceValue()
    {
        $table = new Table();
        $schema = [
            'id'        => ['int', 'sequence'],
            'name'      => ['varchar'],
            'created'   => ['datetime'],
            ];
        $record = new Record($table);
        $record->setColumns($schema);
        $value = 999;
        $record->setSequenceValue($value);

        $this->assertSame($value, $record->id, '-> sets the passed value to the column that has "sequence" option.');
    }
}
