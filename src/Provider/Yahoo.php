<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Provider;

use Robier\EmailNormalization\DomainProvider;
use Robier\EmailNormalization\Feature;

#[Feature\LowercaseName]
#[Feature\RemoveCharacter('.')]
#[Feature\TagAddressing('-')]
final class Yahoo implements DomainProvider
{
    public function domains(): array
    {
        return [
            'yahoo.com',
            // legacy domains used by yahoo
            'yahoo.com.ar',
            'yahoo.com.au',
            'yahoo.at',
            'yahoo.be',
            'yahoo.com.br',
            'ca.yahoo.com',
            'qc.yahoo.com',
            'yahoo.com.co',
            'yahoo.com.hr',
            'yahoo.cz',
            'yahoo.dk',
            'yahoo.fi',
            'yahoo.fr',
            'yahoo.de',
            'yahoo.gr',
            'yahoo.com.hk',
            'yahoo.hu',
            'yahoo.co.in',
            'yahoo.in',
            'yahoo.co.id',
            'yahoo.ie',
            'yahoo.co.il',
            'yahoo.it',
            'yahoo.co.jp',
            'yahoo.com.my',
            'yahoo.com.mx',
            'yahoo.ae',
            'yahoo.nl',
            'yahoo.co.nz',
            'yahoo.no',
            'yahoo.com.ph',
            'yahoo.pl',
            'yahoo.pt',
            'yahoo.ro',
            'yahoo.ru',
            'yahoo.com.sg',
            'yahoo.co.za',
            'yahoo.es',
            'yahoo.se',
            'yahoo.ch',
            'yahoo.com.tw',
            'yahoo.co.th',
            'yahoo.com.tr',
            'yahoo.co.uk',
            'yahoo.com.vn',
            'ymail.com',
            'yahoodns.net',
            'rocketmail.com'
        ];
    }
}
