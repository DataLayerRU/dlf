<?php

use pwf\basic\db\QueryBuilder;
use pwf\helpers\Validator;

class DBModelTest extends \PHPUnit_Framework_TestCase
{
    private $drivers = [
        QueryBuilder::DRIVER_MYSQL,
        QueryBuilder::DRIVER_PG,
        -1
    ];

    public function testCount()
    {
        $query = [
            QueryBuilder::DRIVER_MYSQL => 'SELECT COUNT(id) AS CNT FROM test_table WHERE field1=? AND field2=?',
            QueryBuilder::DRIVER_PG => 'SELECT COUNT(id) AS CNT FROM "test_table" WHERE field1=? AND field2=?',
            -1 => ''
        ];
        foreach ($this->drivers as $driver) {
            $countQuery = $query[$driver];
            QueryBuilder::setDriver($driver);

            $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                    [],
                    [
                    'query' => function($query, $params = []) use($countQuery) {
                        $this->assertEquals($countQuery, $query);

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

            try {
                $model
                    ->table('test_table')
                    ->setPK('id')
                    ->where([
                        'field1' => 1,
                        'field2' => 2
                    ])->count();
            } catch (Exception $ex) {
                if ($driver != -1) {
                    $this->fail($driver.': '.$ex->getMessage());
                }
            }
        }
    }

    public function testDelete()
    {
        $query = [
            QueryBuilder::DRIVER_MYSQL => 'DELETE FROM test_table WHERE field1=? AND field2=?',
            QueryBuilder::DRIVER_PG => 'DELETE FROM "test_table" WHERE field1=? AND field2=?',
            -1 => ''
        ];

        foreach ($this->drivers as $driver) {
            $countQuery = $query[$driver];
            QueryBuilder::setDriver($driver);
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

            try {
                $model
                    ->table('test_table')
                    ->setPK('id')
                    ->where([
                        'field1' => 1,
                        'field2' => 2
                    ])->delete();
            } catch (Exception $ex) {
                if ($driver != -1) {
                    $this->fail($ex->getMessage());
                }
            }
        }
    }

    public function testGetAll()
    {
        $query = [
            QueryBuilder::DRIVER_MYSQL => 'SELECT * FROM test_table WHERE field1=? AND field2=?',
            QueryBuilder::DRIVER_PG => 'SELECT * FROM "test_table" WHERE field1=? AND field2=?',
            -1 => ''
        ];

        foreach ($this->drivers as $driver) {
            $countQuery = $query[$driver];
            QueryBuilder::setDriver($driver);
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

            try {
                $model
                    ->table('test_table')
                    ->setPK('id')
                    ->where([
                        'field1' => 1,
                        'field2' => 2
                    ])->getAll();
            } catch (Exception $ex) {
                if ($driver != -1) {
                    $this->fail($ex->getMessage());
                }
            }
        }
    }

    public function testGetOne()
    {
        $query = [
            QueryBuilder::DRIVER_MYSQL => 'SELECT * FROM test_table WHERE field1=? AND field2=? LIMIT 1',
            QueryBuilder::DRIVER_PG => 'SELECT * FROM "test_table" WHERE field1=? AND field2=? LIMIT 1',
            -1 => ''
        ];

        foreach ($this->drivers as $driver) {
            $countQuery = $query[$driver];
            QueryBuilder::setDriver($driver);
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

            try {
                $model
                    ->table('test_table')
                    ->setPK('id')
                    ->where([
                        'field1' => 1,
                        'field2' => 2
                    ])->getOne();
            } catch (Exception $ex) {
                if ($driver != -1) {
                    $this->fail($ex->getMessage());
                }
            }
        }
    }

    public function testSave()
    {
        $query = [
            QueryBuilder::DRIVER_MYSQL => 'UPDATE test_table SET name=? WHERE id=?',
            QueryBuilder::DRIVER_PG => 'UPDATE "test_table" SET name=? WHERE id=?',
            -1 => ''
        ];

        $query2 = [
            QueryBuilder::DRIVER_MYSQL => 'INSERT INTO test_table (name) VALUES (?)',
            QueryBuilder::DRIVER_PG => 'INSERT INTO "test_table" (name) VALUES (?)',
            -1 => ''
        ];

        foreach ($this->drivers as $driver) {
            $updateQuery = $query[$driver];

            $insertQuery = $query2[$driver];
            QueryBuilder::setDriver($driver);
            $connection  = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                    [],
                    [
                    'exec' => function($query, $params = [])use($updateQuery) {

                        $this->assertEquals($query, $updateQuery);

                        return new PDOStatement();
                    },
                    'insertId' => function($sequenceName = null) {
                        return 1;
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

            try {
                $model
                    ->table('test_table')
                    ->setAttribute('name', 'asdasd')
                    ->setPK('id')
                    ->save();
            } catch (Exception $ex) {
                if ($driver != -1) {
                    $this->fail($ex->getMessage());
                }
            }

            $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                    [],
                    [
                    'exec' => function($query, $params = [])use($insertQuery) {

                        $this->assertEquals($query, $insertQuery);

                        return new PDOStatement();
                    },
                    'insertId' => function($sequenceName = null) {
                        return 1;
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

            try {
                $model
                    ->table('test_table')
                    ->setAttribute('name', 'asdasd')
                    ->setPK('id')
                    ->save();
            } catch (Exception $ex) {
                if ($driver != -1) {
                    $this->fail($ex->getTraceAsString());
                }
            }
        }
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

    public function testValidation()
    {
        $dataValid = [
            'email' => 'test@test.com',
            'equalParam1' => 'test',
            'equalParam2' => 'test',
            'param6' => '123456',
            'param1' => '1'
        ];

        $dataInvalid = [
            'email' => '123qwe',
            'equalParam1' => 'test',
            'equalParam2' => 'test3',
        ];

        $rules = [
            'email' => [
                'required' => false,
                [
                    Validator::VALIDATOR_EMAIL
                ]
            ],
            'equalParam1' => [
                'required' => false,
                [
                    [
                        Validator::VALIDATOR_EQUAL,
                        'equalTo' => 'equalParam2'
                    ],
                    [
                        Validator::VALIDATOR_LENGTH,
                        'max' => 5,
                        'min' => 1
                    ]
                ]
            ],
            'equalParam2' => [
                'required' => false,
                [
                    [
                        Validator::VALIDATOR_LENGTH,
                        'max' => 7,
                        'min' => 1
                    ]
                ]
            ],
            'param6' => [
                'required' => false,
                [
                    [
                        Validator::VALIDATOR_LENGTH,
                        'max' => 7,
                        'min' => 1
                    ]
                ]
            ],
            'param1' => ['required' => true],
            'missedField' => [
                'required' => false,
                [
                    Validator::VALIDATOR_EMAIL
                ]
            ]
        ];

        $model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel',
                [
                'connection' => null
                ],
                [
                'getId' => function() {
                    return 1;
                }
        ]);

        if (!$model->setRules($rules)->setAttributes($dataValid)->validate()) {
            $this->fail(print_r($model->getErrors(), true));
        }
        if ($model->setRules($rules)->setAttributes($dataInvalid)->validate()) {
            $this->fail('Must be false');
        }

//        $this->assertTrue($model->setRules($rules)->setAttributes($dataValid)->validate());
//        $this->assertFalse($model->setRules($rules)->setAttributes($dataInvalid)->validate());
    }
}