<?php

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Stub application
     *
     * @var \pwf\basic\Application
     */
    public static $stubApplication;

    protected function setUp()
    {
        self::$stubApplication = Codeception\Util\Stub::construct('\pwf\basic\Application');
    }

    protected function tearDown()
    {
        self::$stubApplication = null;
    }

    /**
     * @covers \pwf\basic\Application::getRequest
     */
    public function testGetRequest()
    {
        $this->assertNotEmpty(self::$stubApplication->getRequest());
    }

    /**
     * @covers \pwf\basic\Application::getResponse
     */
    public function testGetResponse()
    {
        $this->assertNotEmpty(self::$stubApplication->getResponse());
    }

    /**
     * @covers \pwf\basic\Application::getConfiguration
     * @covers \pwf\basic\Application::setConfiguration
     * @covers \pwf\basic\Application::appendConfiguration
     */
    public function testSetConfiguration()
    {
        $testConfig = [
            'db' => [
                'class' => 'pwf\components\dbconnection\PDOConnection'
            ]
        ];

        $configForAppend = [
            'db' => [
                'dsn' => 'dsn: mysql'
            ]
        ];
        $this->assertTrue(self::$stubApplication->setConfiguration($testConfig)->appendConfiguration($configForAppend)->getConfiguration()
            === array_merge($testConfig, $configForAppend));
    }

    /**
     * @covers \pwf\basic\Application::run
     * @covers \pwf\basic\Application::forceComponentLoading
     * @covers \pwf\basic\Application::prepareCallback
     * @covers \pwf\web\Request::getPath
     * @covers pwf\web\Response::setHeaders
     * @covers pwf\web\Response::send
     * @covers \pwf\basic\RouteHandler::getHandler
     */
    public function testRun()
    {
        try {
            self::$stubApplication->run();
        } catch (Exception $ex) {
            $this->fail($ex->getMessage());
        }

        $this->assertEquals('', self::$stubApplication->getResponse()->getBody());
        $this->assertEquals('HTTP/1.0 404 Not Found',
            self::$stubApplication->getResponse()->getHeaders()[0]);
    }

    /**
     * @covers \pwf\basic\Application::getComponent
     * @covers \pwf\basic\Application::createComponent
     */
    public function testGetComponent()
    {
        $this->assertInstanceOf('pwf\components\dbconnection\PDOConnection',
            self::$stubApplication->setConfiguration([
                'db' => [
                    'class' => 'pwf\components\dbconnection\PDOConnection'
                ]
            ])->getComponent('db'));
    }
}