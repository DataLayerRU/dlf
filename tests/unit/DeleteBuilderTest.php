<?php

class DeleteBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {
        $expected = 'DELETE FROM "test_table" WHERE ID=:ID';

        $builder = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\PostgreSQL\DeleteBuilder');

        $conditionalBuilder = \Codeception\Util\Stub::construct('\pwf\components\querybuilder\adapters\SQL\ConditionBuilder');

        $builder->setConditionBuilder($conditionalBuilder);

        $builder
            ->table('test_table')
            ->where([
                'ID' => 1
        ]);

        $this->assertEquals($expected, $builder->generate());
    }
}