<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;
use Robier\EmailNormalization\Feature;

#[Feature\LowercaseName]
#[Feature\RemoveCharacter('+')]
final class Rackspace implements DomainProvider
{
    public function domains(): array
    {
        return [
            'emailsrvr.com',
        ];
    }
}
