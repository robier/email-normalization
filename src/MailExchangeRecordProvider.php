<?php

declare(strict_types=1);

namespace Robier\EmailNormalization;

interface MailExchangeRecordProvider extends Provider
{
    /**
     * List of MX DNS records used by provider.
     */
    public function records(): array;
}
