<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Feature;

use Robier\EmailNormalization\Email;

/**
 * All descendants need to be declared as attribute:
 *
 * #[Attribute(Attribute::TARGET_CLASS|Attribute::TARGET_METHOD)]
 */
interface Contract
{
    public function handle(Email $email): Email;
}
