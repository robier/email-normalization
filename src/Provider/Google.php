<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;

use Robier\EmailNormalization\Feature;
use Robier\EmailNormalization\MailExchangeRecordProvider;

#[Feature\LowercaseName]
#[Feature\RemoveCharacter('.')]
#[Feature\TagAddressing('+')]
final class Google implements DomainProvider, MailExchangeRecordProvider
{
    /**
     * Regular google email
     *
     * @inheritDoc
     */
    #[Feature\NormalizeHost('gmail.com')]
    public function domains(): array
    {
        return [
            'gmail.com',
            'googlemail.com',
            'google.com',
        ];
    }

    /**
     * Google for work
     *
     * @inheritDoc
     */
    public function records(): array
    {
        return [
            'aspmx.l.google.com',
            'aspmx2.googlemail.com',
            'aspmx3.googlemail.com',
            'alt1.aspmx.l.google.com',
            'alt2.aspmx.l.google.com',
            'alt3.aspmx.l.google.com',
            'alt4.aspmx.l.google.com',
        ];
    }
}
