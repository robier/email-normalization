<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;
use Robier\EmailNormalization\Feature;

#[Feature\LowercaseName]
#[Feature\RemoveCharacter('+')]
final class Rambler implements DomainProvider
{
    public function domains(): array
    {
        return [
            'rambler.ru',
            'lenta.ru',
            'autorambler.ru',
            'myrambler.ru',
            'ro.ru',
        ];
    }
}
