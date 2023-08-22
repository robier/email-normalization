<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Builder;

use Generator;

final class AddTagAddressing implements Contract
{
    private string $name;
    private array $tagCharacters;

    public function __construct(string $name, string ...$tagCharacters)
    {
        $this->name = $name;
        $this->tagCharacters = $tagCharacters;
    }

    public function pipe(iterable $data): Generator
    {
        foreach ($data as $item) {
            yield $item;

            [$name, $domain] = explode('@', $item);

            foreach ($this->tagCharacters as $character) {
                yield sprintf(
                    '%s%s%s@%s',
                    $name,
                    $character,
                    $this->name,
                    $domain,
                );
            }
        }
    }
}
