<?php

declare(strict_types=1);

namespace Robier\EmailNormalization;

interface DomainProvider extends Provider
{
    /**
     * List of domains provider uses.
     */
    public function domains(): array;
}
