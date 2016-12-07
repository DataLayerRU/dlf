<?php

class WebControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var pwf\basic\controller\WebController
     */
    private static $controller;

    protected function setUp()
    {
        self::$controller = \Codeception\Util\Stub::construct('\pwf\basic\controller\WebController');
    }

    protected function tearDown()
    {
        self::$controller = null;
    }

    public function testGetView()
    {
        $this->assertInstanceOf('\pwf\basic\View', self::$controller->getView());
    }

    public function testRender()
    {
        $reflection = new \ReflectionClass(get_class(self::$controller));
        $method     = $reflection->getMethod('render');
        $method->setAccessible(true);

        self::$controller->title = 'Title';

        $this->assertEquals(file_get_contents(__DIR__.'/../_data/testViewResult.html'),
            $method->invokeArgs(self::$controller,
                [
                __DIR__.'/../_data/nestedView.php',
                [
                    'body' => 'Hello, World!',
                    'testBlock' => 'blockValue'
                ]
        ]));
    }
}