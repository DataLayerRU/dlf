<?php

class MySQLQueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    public static $stubBuilder;
    public static $stubConditionBuilder;

    protected function setUp()
    {
        self::$stubBuilder          = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\MySQL\SelectBuilder');
        self::$stubConditionBuilder = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\SQL\ConditionBuilder');
    }

    protected function tearDown()
    {
        self::$stubBuilder          = null;
        self::$stubConditionBuilder = null;
    }

    public function testBuilder()
    {
        $subQuery = clone self::$stubBuilder;

        self::$stubBuilder->setConditionBuilder(self::$stubConditionBuilder);
        $subQuery->setConditionBuilder(clone self::$stubConditionBuilder);

        $this->assertEquals(self::$stubConditionBuilder,
            self::$stubBuilder->getConditionBuilder());

        $subQuery->table('union_table');

        self::$stubBuilder
            ->table('test_table')
            ->select([
                'ID' => 'testId'
            ])
            ->where([
                'TEST_FIELD = 1',
                'ID' => 1,
                ['AND', ['ID1' => 1], 'TEST_FIELD = 2']
            ])
            ->limit(1)
            ->offset(2)
            ->group([
                'group1',
                'group2'
            ])
            ->having([
                'NAME' => 'fake'
            ])
            ->group([
                'ID',
                'NAME'
            ])
            ->join('join_table', 'test_table.ID=join_table.ID_PARENT')
            ->union($subQuery);

        $expected = '(SELECT ID AS testId FROM test_table '
            .'LEFT JOIN join_table ON test_table.ID=join_table.ID_PARENT '
            .'WHERE TEST_FIELD = 1 AND ID=:ID AND ID1=:ID1 AND TEST_FIELD = 2 '
            .'GROUP BY ID, NAME LIMIT 2, 1 HAVING NAME=:NAME) UNION (SELECT * FROM union_table)';

        $testParams = [
            'test' => 1
        ];
        $this->assertEquals($testParams,
            self::$stubConditionBuilder->setParams($testParams)->getParams());
        self::$stubConditionBuilder->setParams([]);

        $this->assertEquals($expected, self::$stubBuilder->generate());

        $this->assertEquals([
            'ID' => 1,
            'NAME' => 'fake',
            'ID1' => 1
            ], self::$stubBuilder->getParams());
    }

    public function testConditionException()
    {
        self::$stubBuilder->where([[]]);
        self::$stubBuilder->setConditionBuilder(self::$stubConditionBuilder);

        try {
            self::$stubBuilder->generate();
            $this->fail();
        } catch (Exception $ex) {
            $this->assertTrue(true);
        }
    }
}