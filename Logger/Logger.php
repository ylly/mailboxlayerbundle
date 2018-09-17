<?php

namespace Ylly\Bundle\MailboxLayer\Logger;

class Logger
{
    /**
     * @var LoggerInterface[]
     */
    private $loggers = [];

    /**
     * @param LoggerInterface $logger
     */
    public function addLogger(LoggerInterface $logger)
    {
        $this->loggers[] = $logger;
    }

    /**
     * @param string $message
     */
    public function write($message)
    {
        foreach ($this->loggers as $logger) {
            $logger->log($message);
        }
    }
}
