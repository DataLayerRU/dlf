<?php

declare(strict_types = 1);

namespace pwf\components\activerecord;

/**
 * @method \pwf\components\activerecord\Model setConnection(\pwf\components\dbconnection\interfaces\Connection $paramName) Set connection
 * @method \pwf\components\dbconnection\interfaces\Connection getConnection() Get connection
 */
abstract class Model extends \pwf\components\activerecord\abstraction\Model
{

    use \pwf\components\datamapper\traits\ErrorTrait;
}