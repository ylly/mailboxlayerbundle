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
    public $messageError = 'error_email_basic';

    /**
     * @var string
     */
    public $messageFormat = 'error_email_format';

    /**
     * @var bool
     */
    public $checkMx = true;

    /**
     * @var string
     */
    public $messageMx = 'error_email_mx';

    /**
     * @var bool
     */
    public $checkSmtp = true;

    /**
     * @var string
     */
    public $messageSmtp = 'error_email_smtp';

    /**
     * @var bool
     */
    public $isCatchAll = false;

    /**
     * @var string
     */
    public $messageCatchAll = 'error_email_catch_all';

    /**
     * @var bool
     */
    public $refuseDisposable = false;

    /**
     * @var string
     */
    public $messageDisposable = 'error_email_disposable';

    /**
     * @var int
     */
    public $refuseUnderScore = 0;

    /**
     * @var string
     */
    public $messageScore = 'error_email_score';

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
