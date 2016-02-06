<?php

class StubClass
{

    public function action($param)
    {
        return $param;
    }

    public function toArray()
    {
        
    }
}

class HelpersTest extends \PHPUnit_Framework_TestCase
{

    public function testArrayHelper()
    {
        $o = \Codeception\Util\Stub::make('StubClass',
                [
                'toArray' => function() {
                    return [
                        'field22' => 'field22value'
                    ];
                }
            ]);

            $arr = [
                'field1' => 'field1value',
                'field2' => $o
            ];

            $this->assertEquals([
                'field1' => 'field1value',
                'field2' => [
                    'field22' => 'field22value'
                ]
                ], \pwf\helpers\ArrayHelper::toArray($arr));
        }

        public function testStringHelper()
        {
            $this->assertEquals(32,
                strlen(\pwf\helpers\StringHelpers::hashString('test')));
        }

        public function testSystemMethodDI()
        {
            $result = 'test';

            $this->assertEquals($result,
                \pwf\helpers\SystemHelpers::call([new StubClass(), 'action'],
                    function($paramName) use ($result) {
                    if ($paramName == 'param') {
                        return $result;
                    }
                }));
        }
    }