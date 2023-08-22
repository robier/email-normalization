<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Feature;

use Generator;
use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Feature\LowercaseName;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Feature\LowercaseName
 */
final class LowercaseNameTest extends TestCase
{
    public function dataProvider(): Generator
    {
        yield 'random case' => ['BaR@foo.com', 'bar@foo.com'];
        yield 'all uppercase' => ['BAR@foo.com', 'bar@foo.com'];
        yield 'all lowercase' => ['bar@foo.com', 'bar@foo.com'];
    }

    /**
     * @dataProvider dataProvider()
     */
    public function testFeature(string $test, string $expected): void
    {
        $feature = new LowercaseName();

        $emailObject = Email::fromString($test);

        self::assertSame(
            (string)$feature->handle($emailObject),
            $expected
        );
    }
}
