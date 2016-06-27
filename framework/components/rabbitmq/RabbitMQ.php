<?php

namespace pwf\components\rabbitmq;

class RabbitMQ implements \pwf\basic\interfaces\Component
{
    /**
     * Queue
     *
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private $mq;

    /**
     * Config
     *
     * @var array
     */
    private $config = [];

    public function init()
    {
        $this->mq = new \PhpAmqpLib\Connection\AMQPStreamConnection($this->config['host'], //
            $this->config['port'], //
            $this->config['user'], //
            $this->config['password'], //
            $this->config['vhost']? : '/', //
            $this->config['insist']? : false, //
            $this->config['loginMethod']? : 'AMQPLAIN', //
            $this->config['loginResponse']? : null, //
            $this->config['locale']? : 'en_US', //
            $this->config['connectionTimeout']? : 3.0, //
            $this->config['readWriteTimeout']? : 3.0, //
            $this->config['context']? : null, //
            $this->config['keepalive']? : false, //
            $this->config['heartbeat']? : 0);
        return $this;
    }

    public function loadConfiguration(array $config = array())
    {
        $this->config = $config;
        return $this;
    }

    public function __set($name, $value)
    {
        $this->mq->$name = $value;
    }

    public function __get($name)
    {
        return $this->mq->$name;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this, $name], $arguments);
    }
}