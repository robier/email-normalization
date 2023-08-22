<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Builder;

use Generator;

final class ReplaceCharacters implements Contract
{
    private array $replacements;

    public function __construct(array $replacements)
    {
        $this->replacements = $replacements;
    }

    public function pipe(iterable $data): Generator
    {
        foreach ($data as $item) {
            yield $item;

            [$name, $domain] = explode('@', $item);

            foreach ($this->replacements as $key => $value) {
                $newEmail = sprintf(
                    '%s@%s',
                    str_replace($key, $value, $name),
                    $domain,
                );

                if ($item === $newEmail) {
                    // no changes
                    continue;
                }

                yield $newEmail;
            }
        }
    }
}
