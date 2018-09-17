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
     * @var $level
     */
    private $level;

    /**
     * @param Logger $monolog
     * @param int $level
     */
    public function __construct(Logger $monolog, $level)
    {
        $this->monolog = $monolog;
        $this->level = $level;
    }

    /**
     * @param string $message
     */
    public function log($message)
    {
        $this->monolog->addRecord($this->level, $message);
    }
}