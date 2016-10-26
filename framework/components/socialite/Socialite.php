<?php

namespace pwf\components\socialite;

/**
 * Socialite adapter
 */
class Socialite extends \Overtrue\Socialite\SocialiteManager implements \pwf\basic\interfaces\Component
{

    public function __construct()
    {
        parent::__construct([]);
    }

    public function init()
    {
        
    }

    public function loadConfiguration(array $config = array())
    {
        $this->config = new \Overtrue\Socialite\Config($config['drivers']);
        return $this;
    }
}