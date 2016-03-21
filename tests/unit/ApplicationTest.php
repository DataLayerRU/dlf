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

    public function testGetRequest()
    {
        $this->assertNotEmpty(self::$stubApplication->getRequest());
    }

    public function testGetResponse()
    {
        $this->assertNotEmpty(self::$stubApplication->getResponse());
    }

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
        $this->assertArrayHasKey('db',
            self::$stubApplication->setConfiguration($testConfig)->appendConfiguration($configForAppend)->getConfiguration());
    }

    public function testRun()
    {
        self::$stubApplication->setConfiguration([
            'db' => [
                'class' => 'pwf\components\dbconnection\PDOConnection',
                'force' => true
            ]
        ]);

        try {
            self::$stubApplication->run();
        } catch (Exception $ex) {
            $this->fail($ex->getMessage());
        }

        $this->assertEquals('404. Not found.',
            self::$stubApplication->getResponse()->getBody());
        $this->assertEquals('HTTP/1.0 404 Not Found',
            self::$stubApplication->getResponse()->getHeaders()[0]);
    }

    public function testRunException()
    {
        \pwf\basic\RouteHandler::registerHandler('/',
            function() {
            throw new Exception('Test');
        });

        self::$stubApplication->getRequest()->setRequestParams([
            'path' => '/'
        ]);

        try {
            self::$stubApplication->run();
            $this->fail();
        } catch (Exception $ex) {

        }
    }

    public function testAnonimus()
    {
        $_POST['testParam'] = '';
        $_GET['testParam2'] = '';

        self::$stubApplication->setConfiguration([
            'db' => [
                'class' => 'pwf\components\dbconnection\PDOConnection'
            ]
        ]);

        \pwf\basic\RouteHandler::registerHandler('/test/(?P<id>\d+)/test',
            function($testParam2, $testParam, $db) {
            return true;
        });

        self::$stubApplication->getRequest()->setRequestParams([
            'path' => '/test/12/test'
        ]);

        try {
            self::$stubApplication->run();
            $this->fail();
        } catch (Exception $ex) {

        }
    }

    public function testGetComponent()
    {
        $this->assertInstanceOf('pwf\components\dbconnection\PDOConnection',
            self::$stubApplication->setConfiguration([
                'db' => [
                    'class' => 'pwf\components\dbconnection\PDOConnection'
                ]
            ])->getComponent('db'));
    }

    public function testComponentException()
    {
        try {
            self::$stubApplication->setConfiguration([
                'db' => [
                    'class' => '\stdClass'
                ]
            ])->getComponent('db');
            $this->fail();
        } catch (Exception $ex) {
            return true;
        }
    }
}