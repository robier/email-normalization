<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;
use Robier\EmailNormalization\Feature;

#[Feature\LowercaseName]
#[Feature\ReplaceCharacter(['-' => '.'])]
#[Feature\TagAddressing('+')]
#[Feature\NormalizeHost('yandex.ru')]
final class Yandex implements DomainProvider
{
    public function domains(): array
    {
        return [
            'narod.ru',
            'yandex.ru',
            'yandex.org',
            'yandex.net',
            'yandex.net.ru',
            'yandex.com.ru',
            'yandex.ua',
            'yandex.com.ua',
            'yandex.by',
            'yandex.eu',
            'yandex.ee',
            'yandex.lt',
            'yandex.lv',
            'yandex.md',
            'yandex.uz',
            'yandex.mx',
            'yandex.do',
            'yandex.tm',
            'yandex.de',
            'yandex.ie',
            'yandex.in',
            'yandex.qa',
            'yandex.so',
            'yandex.nu',
            'yandex.tj',
            'yandex.dk',
            'yandex.es',
            'yandex.pt',
            'yandex.kz',
            'yandex.pl',
            'yandex.lu',
            'yandex.it',
            'yandex.az',
            'yandex.ro',
            'yandex.rs',
            'yandex.sk',
            'yandex.no',
            'ya.ru',
            'yandex.com',
            'yandex.asia',
            'yandex.mobi',
        ];
    }
}
