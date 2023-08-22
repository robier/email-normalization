<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Builder;

use Generator;

final class NameToSubdomain implements Contract
{
    private array $names;

    public function __construct(string $name, string ...$names)
    {
        array_unshift($names, $name);

        $this->names = $names;
    }

    public function pipe(iterable $data): Generator
    {
        foreach ($data as $item) {
            yield $item;

            [$name, $domain] = explode('@', $item);

            foreach ($this->names as $newName) {
                yield sprintf(
                    '%s@%s.%s',
                    $newName,
                    $name, // new subdomain
                    $domain,
                );
            }
        }
    }
}
