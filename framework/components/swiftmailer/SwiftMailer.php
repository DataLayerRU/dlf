<?php

namespace pwf\components\swiftmailer;

class SwiftMailer implements \pwf\basic\interfaces\Component
{
    /**
     * SMTP transport
     */
    const TRANSPORT_SMTP = 'smtp';

    /**
     * By mail() function
     */
    const TRANSPORT_MAIL = 'mail';

    /**
     * Sendmail
     */
    const TRANSPORT_SENDMAIL = 'sendmail';

    /**
     * Configuration
     *
     * @var array
     */
    private $config;

    /**
     * Current transport
     *
     * @var \Swift_Transport
     */
    private $mailer = null;

    /**
     * Messages to send
     *
     * @var array
     */
    private $messages = [];

    /**
     * Component initialization
     *
     * @return \pwf\components\swiftmailer\SwiftMailer
     */
    public function init()
    {
        if (!class_exists('Swift_MailTransport')) {
            throw new \Exception('SwiftMailer need to be installed');
        }
        $transport = null;
        switch ($this->config['transport']) {
            case self::TRANSPORT_SENDMAIL:
                $transport = \Swift_SendmailTransport::newInstance();
                break;
            case self::TRANSPORT_SMTP:
                $transport = \Swift_SmtpTransport::newInstance(isset($this->config['host'])
                                ? $this->config['host'] : 'localhost',
                        isset($this->config['port']) ? $this->config['port'] : 25,
                        isset($this->config['security']) ? $this->config['security']
                                : '')
                    ->setUsername($this->config['username'])
                    ->setPassword($this->config['password']);
                break;
            case self::TRANSPORT_MAIL:
            default:
                $transport = \Swift_MailTransport::newInstance();
        }
        $this->mailer = \Swift_Mailer::newInstance($transport);
        return $this;
    }

    /**
     * Load configuration
     *
     * @param array $config
     * @return \pwf\components\swiftmailer\SwiftMailer
     */
    public function loadConfiguration(array $config = array())
    {
        if (!isset($config['transport'])) {
            $config['transport'] = 'mail';
        }
        $this->config = $config;
        return $this;
    }

    /**
     * Create mail
     *
     * @return \Swift_Message
     */
    public function createMail()
    {
        return \Swift_Message::newInstance();
    }

    /**
     * Add mail
     * 
     * @param \Swift_Message $mail
     * @return \pwf\components\swiftmailer\SwiftMailer
     */
    public function addMail(\Swift_Message $mail)
    {
        $this->messages[] = $mail;
        return $this;
    }

    /**
     * Send all messages
     *
     * @return \pwf\components\swiftmailer\SwiftMailer
     */
    public function send()
    {
        foreach ($this->messages as $mail) {
            $this->mailer->send($mail);
        }
        return $this;
    }

    /**
     * Translate method call to mailer
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_method_array($name, $this->mailer, $arguments);
    }
}