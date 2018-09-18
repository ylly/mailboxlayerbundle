<?php

namespace Ylly\Bundle\MailboxLayer\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Ylly\Bundle\MailboxLayer\Logger\Logger;
use YllyMailboxLayer\EmailChecker;
use YllyMailboxLayer\Exception\CheckerException;

class MailboxLayerValidator extends ConstraintValidator
{
    /**
     * @var EmailChecker
     */
    private $mailChecker;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param EmailChecker $mailChecker
     * @param Logger $logger
     */
    public function __construct(EmailChecker $mailChecker, Logger $logger)
    {
        $this->mailChecker = $mailChecker;
        $this->logger = $logger;
    }

    /**
     * @param string $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        try {
            $response = $this->mailChecker->checkEmail($value, $constraint->isCatchAll);
        } catch (CheckerException $e) {
            if ($constraint->skipIfServerErrors === true) {
                $this->logger->write(sprintf(
                    'The email address %s was accepted and was not verified (%s)',
                    $value,
                    $e->getMessage()
                ));
            } else {
                $this->handleViolation($constraint->messageError);
            }
            return;
        }

        if ($response->getFormatValid() !== true) {
            $this->handleViolation($constraint->messageFormat);
            return;
        }

        if ($constraint->checkMx === true && $response->getMxFound() === false) {
            $this->handleViolation($constraint->messageMx);
            return;
        }

        if ($constraint->checkSmtp === true && $response->getSmtpCheck() === false) {
            $this->handleViolation($constraint->messageSmtp);
            return;
        }

        if ($constraint->isCatchAll === true && $response->getCatchAll() === true) {
            $this->logger->write(sprintf(
                'The email address %s is part of a catch-all mailbox',
                $value
            ));
            $this->handleViolation($constraint->messageCatchAll);
            return;
        }

        if ($constraint->refuseDisposable === true && $response->getDisposable() === true) {
            $this->logger->write(sprintf(
                'The email address %s\'s disposable. Disposable\'s addresses are not accepted',
                $value
            ));
            $this->handleViolation($constraint->messageDisposable);
            return;
        }

        if ($constraint->refuseUnderScore !== 0 && $response->getScore() < $constraint->refuseUnderScore) {
            $this->logger->write(sprintf(
                'The email address %s\'s score (%s) is under the limit accepted (%s)',
                $value,
                $response->getScore(),
                $constraint->refuseUnderScore
            ));
            $this->handleViolation($constraint->messageScore);
            return;
        }
    }

    /**
     * @param string $message
     */
    private function handleViolation($message)
    {
        $this->context->buildViolation($message)->addViolation();
    }
}
