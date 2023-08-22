<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Builder;

use Generator;

final class CombineNameAndDomains implements Contract
{
    private string $name;
    private array $domains;

    public function __construct(string $name, array $domains)
    {
        $this->name = $name;
        $this->domains = $domains;
    }

    public function pipe(iterable $data = null): Generator
    {
        foreach($this->domains as $domain) {
            yield sprintf(
                '%s@%s',
                $this->name,
                $domain,
            );
        }
    }
}
