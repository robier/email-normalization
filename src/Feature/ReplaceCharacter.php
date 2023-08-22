<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Feature;

use Attribute;
use InvalidArgumentException;
use Robier\EmailNormalization\Email;

/**
 * Replaces given map of characters in name part of the email.
 *
 * For example (for replacements `.` -> `:` and `,` -> `;`):
 *      foo.ba,r@test.com -> foo:ba;r@test.com
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class ReplaceCharacter implements Contract
{
    private array $replacements;

    public function __construct(array $replacements)
    {
        foreach ($replacements as $find => $replace) {
            if (mb_strlen($find) !== 1 || mb_strlen($replace) !== 1) {
                throw new InvalidArgumentException("Provided key ($find) and value ($replace) should have only one character");
            }
        }

        $this->replacements = $replacements;
    }

    public function handle(Email $email): Email
    {
        $name = str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            $email->name()
        );

        return new Email($name, $email->domain(), $email->meta());
    }
}
