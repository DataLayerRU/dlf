<?php

class StubClass
{
    private $testField;

    public function setTestField($field)
    {
        $this->testField = $field;
    }

    public function getTestField()
    {
        return $this->testField;
    }

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

        public function testObjectCreate()
        {
            $o = \pwf\helpers\SystemHelpers::createObject('StubClass',
                    [
                    'testField' => 11
            ]);
            $this->assertEquals('11', $o->getTestField());
        }

        public function testGroupArray()
        {
            $arr = [
                [
                    'groupId' => 1,
                    'name' => 'name11'
                ],
                [
                    'groupId' => 1,
                    'name' => 'name12'
                ],
                [
                    'groupId' => 2,
                    'name' => 'name21'
                ]
            ];

            $result = [
                '1' => [
                    [
                        'groupId' => 1,
                        'name' => 'name11'
                    ],
                    [
                        'groupId' => 1,
                        'name' => 'name12'
                    ]
                ],
                '2' => [
                    [
                        'groupId' => 2,
                        'name' => 'name21'
                    ]
                ]
            ];

            $this->assertEquals($result,
                \pwf\helpers\ArrayHelper::groupArray($arr, 'groupId'));
        }

        public function testArrayMap()
        {
            $arr = [
                [
                    'ID' => 5,
                    'NAME' => 'Name'
                ],
                [
                    'ID' => 6,
                    'NAME' => 'Name2'
                ]
            ];

            $this->assertEquals([
                'Name' => 5,
                'Name2' => 6
                ], \pwf\helpers\ArrayHelper::map($arr, 'ID', 'NAME'));
            $this->assertEquals(['Name', 'Name2'],
                \pwf\helpers\ArrayHelper::map($arr, 'NAME'));
            $this->assertEquals([
                5 => [
                    'ID' => 5,
                    'NAME' => 'Name'
                ],
                6 => [
                    'ID' => 6,
                    'NAME' => 'Name2'
                ]
                ], \pwf\helpers\ArrayHelper::map($arr, null, 'ID'));
        }

        public function testRecursiveArraySearch()
        {
            $arr = [
                'test',
                [
                    'test2',
                    'test3'
                ],
                'test4'
            ];

            $this->assertEquals(1,
                \pwf\helpers\ArrayHelper::recursiveArraySearch(null, 'test3',
                    $arr));
        }

        public function testRecursivelySetValue()
        {
            $arr    = [
                'key1' => 'test',
                [
                    'key12' => 'test2',
                    'key13' => 'test3'
                ],
                'key14' => 'test4'
            ];
            $result = [
                'key1' => 'test',
                [
                    'key12' => 'test2',
                    'key13' => 'newValue'
                ],
                'key14' => 'test4'
            ];
            \pwf\helpers\ArrayHelper::recursivelySetValue('key13', 'newValue',
                $arr);
            $this->assertEquals($result, $arr);
            $this->assertEquals('test2',
                \pwf\helpers\ArrayHelper::recursivelyGetValue('key12', $arr));
        }

        public function testXml2Array()
        {
            $xml    = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<root><key1>value1</key1><key2>value2</key2></root>\n";
            $result = [
                'key1' => 'value1',
                'key2' => 'value2'
            ];
            $this->assertEquals($result,
                \pwf\helpers\ConvertHelper::XML2Array($xml));
            $this->assertEquals($xml,
                \pwf\helpers\ConvertHelper::array2XML($result, 'root')->saveXML());
        }
    }