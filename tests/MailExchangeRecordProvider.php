<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test;

use Robier\EmailNormalization\MailExchangeRecordProvider as MailExchangeRecordProviderInterface;

final class MailExchangeRecordProvider implements MailExchangeRecordProviderInterface
{
    private array $domains = [];

    public function __construct(string $domain, string ...$domains)
    {
        array_unshift($domains, $domain);

        $this->domains = $domains;
    }

    public function records(): array
    {
        return $this->domains;
    }
}
