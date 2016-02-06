<?php

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \pwf\components\dbconnection\PDOConnection
     */
    private static $connectionStub;

    protected function setUp()
    {
        self::$connectionStub = \Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'connect' => function() {
                    return true;
                }
        ]);
    }

    protected function tearDown()
    {
        self::$connectionStub = null;
    }

    public function testParams()
    {
        self::$connectionStub->loadConfiguration([
            'login' => 'test',
            'password' => 'test',
            'dsn' => 'test'
        ]);

        $this->assertEquals('test', self::$connectionStub->getDSN());

        $this->assertEquals('test', self::$connectionStub->getLogin());

        $this->assertEquals('test', self::$connectionStub->getPassword());

        $this->assertEquals('test',
            self::$connectionStub->init()->setPDO('test')->getPDO());
    }

    public function testConnect()
    {
        self::$connectionStub->connect();
        self::$connectionStub->disconnect();
    }
}