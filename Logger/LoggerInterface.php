<?php

namespace Ylly\Bundle\MailboxLayer\Logger;

interface LoggerInterface
{
    /**
     * @param string $message
     */
    public function log($message);
}
