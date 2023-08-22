<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Builder;

use Generator;

interface Contract
{
    public function pipe(iterable $data): Generator;
}
