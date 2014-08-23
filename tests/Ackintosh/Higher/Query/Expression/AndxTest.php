<?php
use Ackintosh\Higher\Query\Expression\Andx;
use Ackintosh\Higher\Table;

class ExpressionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function ExpressionAndHasAND()
    {
        $table = new Table;
        $params[0] = '';
        $params[1] = '';
        $params[2] = '';
        $expression = new Andx($table, $params);

        $this->assertSame('AND', TestHelper::getPrivateProperty($expression, 'pre'));
    }

    /**
     * @test
     */
    public function constructorSetsProperties()
    {
        $table = new Table;
        $params[0] = 'testcolumn';
        $params[1] = 'testexpr';
        $params[2] = 'testvlaue';

        $expression = new Andx($table, $params);

        $this->assertSame($table, TestHelper::getPrivateProperty($expression, 'table'));
        $this->assertSame($params[0], TestHelper::getPrivateProperty($expression, 'column'));
        $this->assertSame($params[1], TestHelper::getPrivateProperty($expression, 'expr'));
        $this->assertSame($params[2], TestHelper::getPrivateProperty($expression, 'value'));
    }
}
