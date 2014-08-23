<?php
use Ackintosh\Higher\Query\Expression\Manager;
use Ackintosh\Higher\Table;

class ManagerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->manager = new Manager;
    }

    /**
     * @test
     */
    public function constructorInitializesProperties()
    {
        $this->assertSame([], TestHelper::getPrivateProperty($this->manager, 'exprs'));
    }

    /**
     * @test
     */
    public function _andAddsObjectToProperty()
    {
        $this->manager->_and(new Table, [0, 0, 0]);
        $exprs = TestHelper::getPrivateProperty($this->manager, 'exprs');

        $this->assertInstanceOf('Ackintosh\Higher\Query\Expression\Andx', array_pop($exprs));
    }

    /**
     * @test
     */
    public function _orAddsObjectToProperty()
    {
        $this->manager->_or(new Table, [0, 0, 0]);
        $exprs = TestHelper::getPrivateProperty($this->manager, 'exprs');

        $this->assertInstanceOf('Ackintosh\Higher\Query\Expression\Orx', array_pop($exprs));
    }

    /**
     * @test
     */
    public function toStringCallsThetoStringThatItsPropertyHasAndReturnsString()
    {
    }
}
