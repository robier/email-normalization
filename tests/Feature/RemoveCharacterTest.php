<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Feature;

use Generator;
use \InvalidArgumentException;
use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Feature\RemoveCharacter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Feature\RemoveCharacter
 */
final class RemoveCharacterTest extends TestCase
{
    public function dataProvider(): Generator
    {
        yield 'plus char in name and domain' => ['+', 'ba+r@f+oo.com', 'bar@f+oo.com'];
        yield 'plus char missing' => ['+', 'bar@foo.com', 'bar@foo.com'];
    }

    /**
     * @dataProvider dataProvider()
     */
    public function testFeature(string $char, string $test, string $expected): void
    {
        $feature = new RemoveCharacter($char);

        $emailObject = Email::fromString($test);

        self::assertSame(
            (string)$feature->handle($emailObject),
            $expected
        );
    }

    public function testException(): void
    {
        self::expectExceptionObject(new InvalidArgumentException('Argument 0 is not single character'));

        new RemoveCharacter('ab');
    }
}
