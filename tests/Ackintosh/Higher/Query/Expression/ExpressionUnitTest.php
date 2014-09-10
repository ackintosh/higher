<?php
use Ackintosh\Higher\Query\Expression\ExpressionUnit;
use Ackintosh\Higher\Table;

class ExpressionUnitTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->unit = new ExpressionUnit;
    }

    /**
     * @test
     */
    public function constructorInitializesProperties()
    {
        $this->assertSame([], TestHelper::getPrivateProperty($this->unit, 'exprs'));
    }

    /**
     * @test
     */
    public function _andAddsObjectToProperty()
    {
        $this->unit->_and(new Table, [0, 0, 0]);
        $exprs = TestHelper::getPrivateProperty($this->unit, 'exprs');

        $this->assertInstanceOf('Ackintosh\Higher\Query\Expression\Andx', array_pop($exprs));
    }

    /**
     * @test
     */
    public function _orAddsObjectToProperty()
    {
        $this->unit->_or(new Table, [0, 0, 0]);
        $exprs = TestHelper::getPrivateProperty($this->unit, 'exprs');

        $this->assertInstanceOf('Ackintosh\Higher\Query\Expression\Orx', array_pop($exprs));
    }

    /**
     * @test
     */
    public function toStringCallsThetoStringThatItsPropertyHasAndReturnsString()
    {
    }
}
