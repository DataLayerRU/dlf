<?php

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \pwf\web\Response
     */
    public static $response;

    protected function setUp()
    {
        self::$response = \Codeception\Util\Stub::construct('\pwf\web\Response');
    }

    protected function tearDown()
    {
        self::$response = null;
    }

    public function testCookie()
    {
        self::$response
            ->addCookie('test', 'testValue');

        $this->assertArrayHasKey('test', self::$response->getCookies());
        $this->assertEmpty(self::$response->removeCookie('test')->getCookies()['test']['value']);
        $this->assertArraySubset([
            'Location: /'
            ], self::$response->redirect('/')->getHeaders());
        $this->assertEmpty(self::$response->clear()->getHeaders());
        $this->assertEmpty(self::$response->clear()->getCookies());
    }

    public function testResponseType()
    {
        $this->assertTrue(self::$response->setResponseType(\pwf\web\Response::RESPONSE_RAW)->isRaw());
        $this->assertTrue(self::$response->setResponseType(\pwf\web\Response::RESPONSE_JSON)->isJson());
        $this->assertTrue(self::$response->setResponseType(\pwf\web\Response::RESPONSE_XML)->isXML());
    }

//    public function testCoockieSend()
//    {
//        $body = [
//            'field1' => 'field1value',
//            'field2' => 'field2value'
//        ];
//
//        ob_start();
//        self::$response
//            ->setResponseType(\pwf\web\Response::RESPONSE_JSON)
//            ->addCookie('test', 'testValue')
//            ->setBody($body)
//            ->send();
//        $result = ob_get_clean();
//        $this->assertEquals($result, json_encode($body));
//    }
}