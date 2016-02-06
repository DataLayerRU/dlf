<?php

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var pwf\basic\controller\Controller
     */
    private static $controller;

    protected function setUp()
    {
        self::$controller = \Codeception\Util\Stub::construct('\pwf\basic\controller\Controller');
    }

    protected function tearDown()
    {
        self::$controller = null;
    }

    public function testRequest()
    {
        $requestStub = \Codeception\Util\Stub::construct('\pwf\web\Request',
                [
                'requestParams' => []
        ]);

        $this->assertEquals($requestStub,
            self::$controller->setRequest($requestStub)->getRequest());
    }

    public function testResponse()
    {
        $responseStub = \Codeception\Util\Stub::construct('\pwf\web\Response',
                [
                'headers' => [],
                'cookies' => []
        ]);
        $this->assertEquals($responseStub,
            self::$controller->setResponse($responseStub)->getResponse());
    }
}