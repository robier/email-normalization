<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;
use Robier\EmailNormalization\Feature;

#[Feature\LowercaseName]
#[Feature\RemoveCharacter('+')]
#[Feature\NormalizeHost('icloud.com')]
final class Apple implements DomainProvider
{
    public function domains(): array
    {
        return [
            'icloud.com',
            'me.com',
            'mac.com',
        ];
    }
}
