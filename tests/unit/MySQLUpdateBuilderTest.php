<?php

class MySQLUpdateBuilderTest extends \PHPUnit_Framework_TestCase
{
    public static $stubBuilder;
    public static $stubConditionBuilder;

    protected function setUp()
    {
        self::$stubBuilder          = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\MySQL\UpdateBuilder');
        self::$stubConditionBuilder = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\SQL\ConditionBuilder');
        self::$stubBuilder->setConditionBuilder(self::$stubConditionBuilder);
    }

    protected function tearDown()
    {
        self::$stubBuilder          = null;
        self::$stubConditionBuilder = null;
    }

    public function testBuilder()
    {
        $params     = [
            'PARAM1' => 1,
            'PARAM2' => 2,
            'PARAM3' => 3,
        ];
        $conditions = [
            'condition1' => 1
        ];
        $expected   = 'UPDATE "table_test" SET PARAM1=:PARAM1, PARAM2=:PARAM2, PARAM3=:PARAM3 WHERE condition1=:condition1';

        self::$stubBuilder->table('table_test')->setParams($params)->where($conditions);

        $this->assertEquals($expected, self::$stubBuilder->generate());

        $this->assertEquals(array_merge($params,
                [
            'condition1' => 1
            ]), self::$stubBuilder->getParams());
    }
}