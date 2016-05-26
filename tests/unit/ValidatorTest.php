<?php

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;

    protected function setUp()
    {
        $this->validator = \Codeception\Util\Stub::construct('\pwf\components\validator\Validator');
    }

    protected function tearDown()
    {
        $this->validator = null;
    }

    public function testIt()
    {
        $rules = [
            ['equal', 'name', 'value' => 'testName'],
            ['equal', 'password', 'param' => 'password2'],
            ['length', 'text', 'min' => 5, 'max' => 255],
            ['email', ['email']],
            ['callback', 'callb', function($fieldName, $value) {
                    return true;
                }]
        ];
    }
}