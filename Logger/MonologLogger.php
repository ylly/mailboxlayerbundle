<?php

namespace Ylly\Bundle\MailboxLayer\Logger;

use Symfony\Bridge\Monolog\Logger;

class MonologLogger implements LoggerInterface
{
    /**
     * @var Logger
     */
    private $monolog;

    /**
     * @param Logger $monolog
     */
    public function __construct(Logger $monolog)
    {
        $this->monolog = $monolog;
    }

    /**
     * @param string $message
     */
    public function log($message)
    {
        $this->monolog->addInfo($message);
    }
}