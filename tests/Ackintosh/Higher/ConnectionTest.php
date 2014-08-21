<?php
use Ackintosh\Higher\Connection;

class ConnectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider connectionSettings
     */
    public function makeDsn($setting, $expect)
    {
        $con = new Connection($setting);
        $res = TestHelper::invokePrivateMethod($con, 'makeDsn', []);

        $this->assertSame($expect, $res);
    }

    public function connectionSettings()
    {
        return [
            [
                [
                'type'      => 'mysql',
                'host'      => 'localhost',
                'port'      => 8889,
                'dbname'    => 'higher',
                'user'      => 'testuser',
                'password'  => 'testpassword',
                'charset'   => 'utf8',
                ],
                'mysql:host=localhost;port=8889;dbname=higher;charset=utf8;',
            ],
            ];

    }
}
