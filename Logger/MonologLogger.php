<?php

namespace Ylly\Bundle\MailboxLayer\Logger;

use Symfony\Bridge\Monolog\Logger as Monolog;

class MonologLogger implements LoggerInterface
{
    /**
     * @var Monolog
     */
    private $monolog;

    /**
     * @var $level
     */
    private $level;

    /**
     * @param Monolog $monolog
     * @param int $level
     */
    public function __construct(Monolog $monolog, $level)
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