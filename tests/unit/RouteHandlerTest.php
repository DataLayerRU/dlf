<?php

class RouteHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function getRoutes()
    {
        return [
            ['/', 'TestClass::run']
        ];
    }

    public function getUrls()
    {
        return [
            ['/main/test', '\\project\\controllers\\MainController::test'],
            ['/reference/main-test/test-action', '\\project\\controllers\\reference\\MainTestController::testAction']
        ];
    }

    /**
     * @dataProvider getRoutes
     * @covers \pwf\basic\RouteHandler::registerHandler
     * @covers \pwf\basic\RouteHandler::getHandler
     */
    public function testRouteHandler($route, $handler)
    {
        \pwf\basic\RouteHandler::registerHandler($route, $handler);
        $this->assertEquals($handler,
            \pwf\basic\RouteHandler::getHandler($route));
    }

    /**
     * @dataProvider getUrls
     * @covers \pwf\basic\RouteHandler::parseRoute
     * @covers \pwf\basic\RouteHandler::preparePart
     */
    public function testParseRoute($have, $expected)
    {
        $this->assertEquals($expected,
            \pwf\basic\RouteHandler::parseRoute($have));
    }
}