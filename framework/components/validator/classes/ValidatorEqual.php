<?php

namespace pwf\components\validator\classes;

class ValidatorEqual implements \pwf\components\validator\interfaces\Validator
{
    /**
     * Minimum length
     *
     * @var int
     */
    private $min;

    /**
     * Maximum length
     *
     * @var int
     */
    private $max;

    /**
     * @param int $min
     * @param int $max
     */
    public function __construct($min = 0, $max = 0)
    {
        $this->setMin($min)->setMax($max);
    }

    /**
     * Set minimum length
     *
     * @param int $min
     * @return \pwf\components\validator\classes\ValidatorLength
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * Get minimum length
     *
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set maximum length
     *
     * @param int $max
     * @return \pwf\components\validator\classes\ValidatorLength
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    /**
     * Get maximum length
     *
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    public function validate($data)
    {
        $result = true;
        $max    = $this->getMax();
        if ($max === null) {
            throw new \Exception('\'length\' validator needes \'max\' param');
        }
        $length = strlen($data);
        if ($length < $this->getMin()) {
            $result = false;
        }
        if ($length > $max) {
            $result = false;
        }
        return $result;
    }
}