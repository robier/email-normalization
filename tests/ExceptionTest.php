<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test;

use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Exception
 */
final class ExceptionTest extends TestCase
{
    public function testObjectConstruction(): void
    {
        $test = new Exception('foo bar');

        self::assertSame('foo bar', $test->getMessage());
    }

    public function testObjectConstructionFrom(): void
    {
        $email = Email::fromString('foo@bar.com');

        $test = Exception::noProviderFoundFor($email);

        self::assertSame('No provider detected for email ' . $email, $test->getMessage());
    }
}
