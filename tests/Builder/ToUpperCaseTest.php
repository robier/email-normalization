<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Builder;

use Robier\EmailNormalization\Builder\ToUpperCase;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Builder\ToUpperCase
 */
final class ToUpperCaseTest extends TestCase
{
    /**
     * @dataProvider dataProvider()
     */
    public function testPipe(string $input, array $expected): void
    {
        $pipe = new ToUpperCase();

        $data = iterator_to_array($pipe->pipe([$input]));

        self::assertSame(
            $expected,
            $data,
        );
    }

    public function dataProvider(): \Generator
    {
        yield 'lowercase' => ['foo@bar.com', ['foo@bar.com', 'FOO@bar.com']];
        yield 'uppercase' => ['FOO@bar.com', ['FOO@bar.com']];
        yield 'combined' => ['FoObAr@bar.com', ['FoObAr@bar.com', 'FOOBAR@bar.com']];
    }
}
