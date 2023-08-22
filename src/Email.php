<?php

declare(strict_types=1);

namespace Robier\EmailNormalization;

/**
 * @internal
 */
final class Email
{
    public function __construct(
        private string $name,
        private string $domain,
        private array $meta = []
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function __toString(): string
    {
        return $this->name . '@' . $this->domain;
    }

    public function meta(): array
    {
        return $this->meta;
    }

    public static function fromString(string $email, array $meta = []): self
    {
        $email = trim($email);

        [$name, $domain] = explode('@', $email);

        // domain is always lower cased
        $domain = mb_strtolower($domain);

        return new self($name, $domain, $meta);
    }
}
