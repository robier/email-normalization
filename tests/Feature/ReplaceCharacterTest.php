<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Feature;

use Generator;
use \InvalidArgumentException;
use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Feature\ReplaceCharacter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Feature\ReplaceCharacter
 */
final class ReplaceCharacterTest extends TestCase
{
    public function dataProvider(): Generator
    {
        yield 'plus to dot in name only' => [['+' => '.'], 'ba+r@f+oo.com', 'ba.r@f+oo.com'];
        yield 'plus to dot missing' => [['+' => '.'], 'bar@f+oo.com', 'bar@f+oo.com'];
    }

    /**
     * @dataProvider dataProvider()
     */
    public function testFeature(array $replacements, string $test, string $expected): void
    {
        $feature = new ReplaceCharacter($replacements);

        $emailObject = Email::fromString($test);

        self::assertSame(
            (string)$feature->handle($emailObject),
            $expected
        );
    }

    public function testException(): void
    {
        self::expectExceptionObject(
            new InvalidArgumentException('Provided key (foo) and value (bar) should have only one character')
        );

        new ReplaceCharacter(['foo' => 'bar']);
    }
}
