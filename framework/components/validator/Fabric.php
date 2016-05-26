<?php

namespace pwf\components\validator;

class Fabric
{
    /**
     * Check equal
     */
    const VALIDATOR_EQUAL = 'equal';

    /**
     * Check string length
     */
    const VALIDATOR_LENGTH = 'length';

    /**
     * Check email address
     */
    const VALIDATOR_EMAIL = 'email';

    /**
     * Check by user defined function
     */
    const VALIDATOR_USER = 'callback';

    public static function createValidator($type, array $params)
    {
        $result = null;
        switch ($type) {
            case self::VALIDATOR_LENGTH:
                $result = new classes\ValidatorLength();
                if (isset($params['min'])) {
                    $result->setMin($params['min']);
                }
                if (isset($params['max'])) {
                    $result->setMax($params['max']);
                }
                break;
            case self::VALIDATOR_EMAIL:
                break;
            case self::VALIDATOR_EQUAL:
                break;
            case self::VALIDATOR_USER:
                break;
            default:
                throw new \Exception('Unknown validator');
        }
        return $result;
    }
}