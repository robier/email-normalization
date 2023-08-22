<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Feature;

use Attribute;
use Robier\EmailNormalization\Email;

/**
 * Sets default domain to provided email.
 *
 * For example (for default domain `test.com`):
 *      foo@bar.com -> foo@test.com
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class NormalizeHost implements Contract
{
    private string $domain;

    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    public function handle(Email $email): Email
    {
        return new Email($email->name(), $this->domain, $email->meta());
    }
}
