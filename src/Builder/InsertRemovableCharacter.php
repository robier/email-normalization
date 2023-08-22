<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Builder;

use Generator;

final class InsertRemovableCharacter implements Contract
{
    private array $characters;

    public function __construct(string $character, string ...$characters)
    {
        array_unshift($characters, $character);

        $this->characters = $characters;
    }

    public function pipe(iterable $data): Generator
    {
        foreach($data as $item) {
            yield $item;

            [$name, $domain] = explode('@', $item);

            foreach($this->characters as $character) {
                yield sprintf(
                    '%s@%s',
                    implode($character, str_split($name)),
                    $domain,
                );
            }
        }
    }
}
