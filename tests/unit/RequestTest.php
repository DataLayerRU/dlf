<?php

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \pwf\web\Request
     */
    public static $request;

    protected function setUp()
    {
        self::$request = \Codeception\Util\Stub::construct('\pwf\web\Request',
                [
                'requestParams' => []
        ]);
    }

    protected function tearDown()
    {
        self::$request = null;
    }

    public function testRequestParams()
    {
        $params = [
            'path' => '/main'
        ];
        $this->assertArraySubset($params,
            self::$request->setRequestParams($params)->getRequestParams());
        $this->assertEquals('/main', self::$request->getPath());
        $this->assertEquals($params, self::$request->get());
        $this->assertEquals('/main', self::$request->get('path'));
    }

    public function httpMethods()
    {
        return[
            ['POST', 'isPost', true],
            ['GET', 'isGet', true],
            ['GET', 'isPost', false]
        ];
    }

    /**
     * @dataProvider httpMethods
     */
    public function testHttpMethods($httpMethod, $method, $result)
    {
        $_SERVER['REQUEST_METHOD'] = $httpMethod;
        $this->assertEquals($result, self::$request->$method());
    }

    public function testCookies()
    {
        $_COOKIE['test'] = 'testValue';
        $this->assertEquals('testValue', self::$request->getCookie('test'));
    }
}