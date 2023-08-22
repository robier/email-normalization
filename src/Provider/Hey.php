<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;
use Robier\EmailNormalization\Feature;

#[Feature\LowercaseName]
#[Feature\TagAddressing('+')]
final class Hey implements DomainProvider
{
    public function domains(): array
    {
        return [
            'hey.com',
        ];
    }
}
