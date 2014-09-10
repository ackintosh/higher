<?php
use Ackintosh\Higher\Query\Where;
use Ackintosh\Higher\Table;

class WhereTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $table1 = new Table();
        $table2 = new Table();
        $args = [
            function ($expr) use ($table1, $table2) {
                $expr->_($table1, ['id', '=', 123]);
                $expr->_and($table2, ['addr', '=', 'foo']);
            },
            'AND',
            function ($expr) use ($table1, $table2) {
                $expr->_($table1, ['id', '=', 456]);
                $expr->_or($table2, ['addr', '=', 'bar']);
            }
            ];
        $this->where = new Where($args);
    }

    /**
     * @test
     */
    public function constructor()
    {
        $expressions = TestHelper::getPrivateProperty($this->where, 'expressions');
        $this->assertInstanceOf('\Ackintosh\Higher\Query\Expression\ExpressionUnit', $expressions[0], '-> sets "ExpressionUnit" object.');
        $this->assertSame('AND', $expressions[1], '-> sets string.');
        $this->assertInstanceOf('\Ackintosh\Higher\Query\Expression\ExpressionUnit', $expressions[2], '-> sets "ExpressionUnit" object.');
    }

    /**
     * @test
     */
    public function toString()
    {
        $expect = ' WHERE  (  `table`.`id` = ? AND `table`.`addr` = ? ) AND (  `table`.`id` = ? OR `table`.`addr` = ? ) ';
        $actual = $this->where->toString();
        $this->assertSame($expect, $actual, '-> returns "WHERE" clause.');
    }

    /**
     * @test
     */
    public function getValues()
    {
        $expect = [123, 'foo', 456, 'bar'];
        $actual = $this->where->getValues();
        $this->assertSame($expect, $actual, '-> returns the array values that be used for "WHERE" clause.');
    }
}
