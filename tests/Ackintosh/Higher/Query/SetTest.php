<?php
use Ackintosh\Higher\Query\Set;

class SetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function constructor()
    {
        $params = ['foo' => 123, 'bar' => 456];
        $set = new Set($params);

        $this->assertSame($params, TestHelper::getPrivateProperty($set, 'params'), '-> sets the params to "params" property.');
    }

    /**
     * @test
     */
    public function toString()
    {
        $params = ['foo' => 123, 'bar' => 456];
        $set = new Set($params);
        $expect = ' SET `foo` = ?, `bar` = ?';

        $this->assertSame($expect, $set->toString(), '-> returns "SET" clause.');
    }

    /**
     * @test
     */
    public function getValues()
    {
        $params = ['foo' => 123, 'bar' => 456];
        $set = new Set($params);
        $expect = [123, 456];

        $this->assertSame($expect, $set->getValues(), '-> returns the array values that be used for "SET" clause.');
    }
}
