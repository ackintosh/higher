<?php
use Ackintosh\Higher\Query\ExpressionOr;
use Ackintosh\Higher\Table;

class ExpressionOrTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function ExpressionOrHasOR()
    {
        $table = new Table;
        $params[0] = '';
        $params[1] = '';
        $params[2] = '';
        $expression = new ExpressionOr($table, $params);

        $this->assertSame('OR', TestHelper::getPrivateProperty($expression, 'pre'));
    }
}
