<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Feature;

use Attribute;
use Robier\EmailNormalization\Email;

/**
 * Removes addressing sign and everything beyond that, before @ sign.
 *
 * For example: (if tag sign is "+")
 *      foo+bar@test.com -> foo@test.com
 *
 * @see \Robier\EmailNormalization\Test\Feature\TagAddressingTest
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class TagAddressing implements Contract
{
    private string $sign;

    public function __construct(string $sign)
    {
        $this->sign = $sign;
    }

    public function handle(Email $email): Email
    {
        if (($position = strpos($email->name(), $this->sign)) === false) {
            return $email;
        }

        $name = substr($email->name(), 0, $position);

        return new Email($name, $email->domain(), $email->meta());
    }
}
