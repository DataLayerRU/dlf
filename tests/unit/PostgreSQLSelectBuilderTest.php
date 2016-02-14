<?php

class PostgreSQLSelectBuilderTest extends \PHPUnit_Framework_TestCase
{
    public static $stubBuilder;
    public static $stubConditionBuilder;

    protected function setUp()
    {
        self::$stubBuilder          = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\PostgreSQL\SelectBuilder');
        self::$stubConditionBuilder = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\SQL\ConditionBuilder');
    }

    protected function tearDown()
    {
        self::$stubBuilder          = null;
        self::$stubConditionBuilder = null;
    }

    public function testSelect()
    {
        self::$stubBuilder->setConditionBuilder(self::$stubConditionBuilder);

        $expected = 'SELECT ID AS testId FROM test_table LIMIT 1 OFFSET 2';

        self::$stubBuilder
            ->table('test_table')
            ->select([
                'ID' => 'testId'
            ])
            ->limit(1)
            ->offset(2);

        $this->assertEquals($expected, self::$stubBuilder->generate());
    }
}