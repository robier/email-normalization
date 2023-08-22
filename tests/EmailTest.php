<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test;

use Robier\EmailNormalization\Email;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Email
 */
final class EmailTest extends TestCase
{
    public function testNameGetter(): void
    {
        $email = new Email('foo', 'bar.com');

        self::assertSame($email->name(), 'foo');
    }

    public function testDomainGetter(): void
    {
        $email = new Email('foo', 'bar.com');

        self::assertSame($email->domain(), 'bar.com');
    }

    public function testMetaGetter(): void
    {
        $meta = ['foo' => 'bar'];
        $email = new Email('foo', 'bar.com', $meta);

        self::assertSame($email->meta(), $meta);
    }

    public function testToString(): void
    {
        $email = new Email('foo', 'bar.com');

        self::assertSame('foo@bar.com', (string) $email);
    }

    public function testFromStringFactory(): void
    {
        $meta = ['foo' => 'bar'];
        $email = Email::fromString('foo@bar.com', $meta);

        self::assertSame('foo@bar.com', (string) $email);
        self::assertSame($meta, $email->meta());
    }
}
