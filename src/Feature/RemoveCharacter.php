<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Feature;

use Attribute;
use InvalidArgumentException;
use Robier\EmailNormalization\Email;

/**
 * Removes provided set of characters from name part of email.
 *
 * For example (for '.' and '+'):
 *      foo+b.ar@test.com -> foobar@test.com
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class RemoveCharacter implements Contract
{
    /** @var string[] */
    private array $characters;

    public function __construct(string $character, string ...$characters)
    {
        array_unshift($characters, $character);
        foreach ($characters as $key => $character) {
            if (mb_strlen($character) !== 1) {
                throw new InvalidArgumentException("Argument $key is not single character");
            }
        }

        $this->characters = $characters;
    }

    public function handle(Email $email): Email
    {
        $name = str_replace($this->characters, '', $email->name());

        return new Email($name, $email->domain(), $email->meta());
    }
}
