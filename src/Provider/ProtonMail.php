<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;
use Robier\EmailNormalization\Feature;

#[Feature\LowercaseName]
#[Feature\RemoveCharacter('+')]
#[Feature\NormalizeHost('protonmail.ch')]
final class ProtonMail implements DomainProvider
{
    public function domains(): array
    {
        return [
            'protonmail.ch',
            'protonmail.com',
            'pm.me',
        ];
    }
}
