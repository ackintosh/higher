<?php
use Ackintosh\Higher\Query\Join;
use Ackintosh\Higher\Table;

class JoinTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->t1 = new Table;
        $this->t2 = new Table;
        $this->on = ['on1' => 'on2'];
    }

    /**
     * @test
     */
    public function constructorSetsProperties()
    {
        $join = new Join($this->t1, $this->t2, $this->on);

        $this->assertSame($this->t1, TestHelper::getPrivateProperty($join, 'owner'));
        $this->assertSame($this->t2, TestHelper::getPrivateProperty($join, 'target'));
        $this->assertSame($this->on, TestHelper::getPrivateProperty($join, 'on'));
    }

    /**
     * @test
     */
    public function toString()
    {
        $join = new Join($this->t1, $this->t2, $this->on);
        $expect = 'INNER JOIN `table` ON `table`.`on1` = `table`.`on2`';

        $this->assertSame($expect, $join->toString());
    }
}
