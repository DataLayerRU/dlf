<?php

class DBModelTest extends \PHPUnit_Framework_TestCase
{
    private static $model;

    protected function setUp()
    {
        \pwf\basic\db\QueryBuilder::setDriver(\pwf\basic\db\QueryBuilder::DRIVER_MYSQL);
    }

    public function testCount()
    {
        $countQuery = 'SELECT COUNT(id) AS CNT FROM test_table WHERE field1=:field1 AND field2=:field2';

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'query' => function($query, $params = []) use($countQuery) {

                $this->assertEquals($query, $countQuery);

                return new PDOStatement();
            }
        ]);

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => $connection
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        $model
            ->table('test_table')
            ->setPK('id')
            ->where([
                'field1' => 1,
                'field2' => 2
            ])->count();
    }

    public function testDelete()
    {
        $countQuery = 'DELETE FROM test_table WHERE field1=:field1 AND field2=:field2';

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'exec' => function($query, $params = [])use($countQuery) {

                $this->assertEquals($query, $countQuery);

                return new PDOStatement();
            }
        ]);

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => $connection
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        $model
            ->table('test_table')
            ->setPK('id')
            ->where([
                'field1' => 1,
                'field2' => 2
            ])->delete();
    }

    public function testGetAll()
    {
        $countQuery = 'SELECT * FROM test_table WHERE field1=:field1 AND field2=:field2';

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'query' => function($query, $params = []) use($countQuery) {

                $this->assertEquals($query, $countQuery);

                return new PDOStatement();
            }
        ]);

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => $connection
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        $model
            ->table('test_table')
            ->setPK('id')
            ->where([
                'field1' => 1,
                'field2' => 2
            ])->getAll();
    }

    public function testGetOne()
    {
        $countQuery = 'SELECT * FROM test_table WHERE field1=:field1 AND field2=:field2 LIMIT 1';

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'query' => function($query, $params = []) use($countQuery) {

                $this->assertEquals($query, $countQuery);

                return new PDOStatement();
            }
        ]);

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => $connection
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        $model
            ->table('test_table')
            ->setPK('id')
            ->where([
                'field1' => 1,
                'field2' => 2
            ])->getOne();
    }

    public function testGenerate()
    {
        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => null
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        try {
            $model->generate();
            $this->assertTrue(false);
        } catch (\Exception $ex) {

        }
    }

    public function testSave()
    {
        $updateQuery = 'UPDATE test_table SET name=:name WHERE id=:id';

        $insertQuery = 'INSERT INTO test_table (name) VALUES (:name)';

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'exec' => function($query, $params = [])use($updateQuery) {

                $this->assertEquals($query, $updateQuery);

                return new PDOStatement();
            }
        ]);

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => $connection
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        $model
            ->table('test_table')
            ->setAttribute('name', 'asdasd')
            ->setPK('id')
            ->save();

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'exec' => function($query, $params = [])use($insertQuery) {

                $this->assertEquals($query, $insertQuery);

                return new PDOStatement();
            }
        ]);

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => $connection
                ],
                [
                'getId' => function() {
                    return null;
                }
        ]);

        $model
            ->table('test_table')
            ->setAttribute('name', 'asdasd')
            ->setPK('id')
            ->save();
    }

    /**************Postgre***************/
    public function testGetOnePG()
    {
        \pwf\basic\db\QueryBuilder::setDriver(\pwf\basic\db\QueryBuilder::DRIVER_PG);

        $countQuery = 'SELECT * FROM test_table WHERE field1=:field1 AND field2=:field2 LIMIT 1';

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'query' => function($query, $params = []) use($countQuery) {

                $this->assertEquals($query, $countQuery);

                return new PDOStatement();
            }
        ]);

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => $connection
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        $model
            ->table('test_table')
            ->setPK('id')
            ->where([
                'field1' => 1,
                'field2' => 2
            ])->getOne();
    }
}