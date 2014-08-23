<?php
use Ackintosh\Higher\Query\Expression\Orx;
use Ackintosh\Higher\Table;

class OrxTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function OrHasOR()
    {
        $table = new Table;
        $params[0] = '';
        $params[1] = '';
        $params[2] = '';
        $expression = new Orx($table, $params);

        $this->assertSame('OR', TestHelper::getPrivateProperty($expression, 'pre'));
    }
}
