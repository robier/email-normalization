<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Feature;

use Generator;
use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Feature\TagAddressing;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Feature\TagAddressing
 */
final class TagAddressingTest extends TestCase
{
    public function dataProvider(): Generator
    {
        yield 'plus sign' => ['+', 'foo+bar@test.com', 'foo@test.com'];
        yield 'minus sign' => ['-', 'foo-bar@test.com', 'foo@test.com'];
        yield 'dot sign' => ['.', 'foo.bar@test.com', 'foo@test.com'];
        yield 'multiple signs' => ['+', 'foo+b+a+r@test.com', 'foo@test.com'];
        yield 'no signs' => ['+', 'foobar@test.com', 'foobar@test.com'];
    }

    /**
     * @dataProvider dataProvider()
     */
    public function testFeature(string $sign, string $test, string $expected): void
    {
        $feature = new TagAddressing($sign);

        $email = $feature->handle(Email::fromString($test));

        self::assertSame((string)$email, $expected);
    }
}
