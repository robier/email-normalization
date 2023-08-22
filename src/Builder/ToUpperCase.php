<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Builder;

use Generator;

final class ToUpperCase implements Contract
{
    public function pipe(iterable $data): Generator
    {
        foreach ($data as $item) {
            yield $item;

            [$name, $domain] = explode('@', $item);

            $newEmail = sprintf(
                '%s@%s',
                mb_strtoupper($name),
                $domain,
            );

            if ($newEmail === $item) {
                continue;
            }

            yield $newEmail;
        }
    }
}
