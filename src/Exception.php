<?php

declare(strict_types=1);

namespace Robier\EmailNormalization;

use Exception as GlobalException;

final class Exception extends GlobalException
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }

    static function noProviderFoundFor(Email $email): self
    {
        return new self('No provider detected for email ' . $email);
    }
}
