<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Feature;

use Attribute;
use Robier\EmailNormalization\Email;

/**
 * Transforms name part of email to lowercase.
 *
 * For example:
 *      Foo.BAR@test.com -> foo.bar@test.com
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class LowercaseName implements Contract
{
    public function handle(Email $email): Email
    {
        return new Email(mb_strtolower($email->name()), $email->domain(), $email->meta());
    }
}
