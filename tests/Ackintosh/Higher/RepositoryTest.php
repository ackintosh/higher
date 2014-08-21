<?php
use Ackintosh\Higher\Repository;
use Ackintosh\Higher\Config;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getClassNameReturnsCamelCase()
    {
        $repo = new Repository(new Config);

        $res = TestHelper::invokePrivateMethod ($repo, 'getClassName', ['foo']);
        $this->assertSame('Foo', $res);

        $res = TestHelper::invokePrivateMethod ($repo, 'getClassName', ['foo_bar']);
        $this->assertSame('FooBar', $res);
    }
}
