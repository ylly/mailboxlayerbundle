<?php

namespace Ylly\Bundle\MailboxLayer\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MailboxLayer extends Constraint
{
    /**
     * @var string
     */
    public $messageError = 'An error occurred during the verifications of your email';

    /**
     * @var string
     */
    public $messageFormat = 'The format is invalid';

    /**
     * @var bool
     */
    public $checkMx = true;

    /**
     * @var string
     */
    public $messageMx = 'There is no MX-records for this email address';

    /**
     * @var bool
     */
    public $checkSmtp = true;

    /**
     * @var string
     */
    public $messageSmtp = 'The smtp request cannot be handled by the server';

    /**
     * @var bool
     */
    public $isCatchAll = false;

    /**
     * @var string
     */
    public $messageCatchAll = 'The smtp request cannot be handled by the server';

    /**
     * @var bool
     */
    public $refuseDisposable = false;

    /**
     * @var string
     */
    public $messageDisposable = 'Your email address is disposable. Please provides one which is not';

    /**
     * @var int
     */
    public $refuseUnderScore = 0;

    /**
     * @var string
     */
    public $messageScore = 'The quality score of the email address is too low. Please, provides another one';

    /**
     * @var bool
     */
    public $skipIfServerErrors = true;

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'mailbox_layer';
    }
}
