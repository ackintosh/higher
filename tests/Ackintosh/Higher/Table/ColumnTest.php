<?php
use Ackintosh\Higher\Table\Column;

class ColumnTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->name = 'testname';
        $this->type = 'testtype';
        $this->option = ['opt1', 'opt2'];
        $this->column = new Column($this->name, $this->type, $this->option);
    }

    /**
     * @test
     */
    public function constructorSetsProperties()
    {
        $this->assertSame($this->name,   TestHelper::getPrivateProperty($this->column, 'name'));
        $this->assertSame($this->type,   TestHelper::getPrivateProperty($this->column, 'type'));
        $this->assertSame($this->option, TestHelper::getPrivateProperty($this->column, 'option'));
    }

    /**
     * @test
     */
    public function setValue()
    {
        $value = 'testvalue';
        $column = new Column($this->name, $this->type, $this->option);
        $column->setValue($value);

        $this->assertSame($value, TestHelper::getPrivateProperty($column, 'value'));
    }

    /**
     * @test
     */
    public function getValue()
    {
        $value = 'testvalue';
        $column = new Column($this->name, $this->type, $this->option);
        $column->setValue($value);
        $this->assertSame($value, $column->getValue());
    }

    /**
     * @test
     */
    public function isSequence()
    {
        $this->assertFalse($this->column->isSequence());

        $col = new Column($this->name, $this->type, ['sequence']);
        $this->assertTrue($col->isSequence());
    }
}
