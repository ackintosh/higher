<?php
use Ackintosh\Higher\Query\Select;
use Ackintosh\Higher\Table;

class SelectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructorSetsProperty()
    {
        $table = new Table;
        $columns = ['col1', 'col2'];
        $select = new Select($columns);
        $select->from($table);

        $this->assertSame($columns, TestHelper::getPrivateProperty($select, 'columns'));
        $this->assertSame([], TestHelper::getPrivateProperty($select, 'joins'));
        $this->assertSame([], TestHelper::getPrivateProperty($select, 'expressions'));
    }

    /**
     * @test
     */
    public function joinPushesJoinObjecttoProperty()
    {
        $table = new Table;
        $columns = ['col1', 'col2'];
        $select = new Select($columns);
        $select->from($table);

        $table2 = new Table;
        $select->join($table2, ['on1' => 'on2']);

        $joins = TestHelper::getPrivateProperty($select, 'joins');
        $this->assertInstanceOf('Ackintosh\Higher\Query\Join', array_pop($joins));
    }
}
