<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Builder;

use Robier\EmailNormalization\Builder\ReplaceCharacters;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Builder\ReplaceCharacters
 */
final class ReplaceCharactersTest extends TestCase
{
    public function testPipe(): void
    {
        $pipe = new ReplaceCharacters(['.' => ':', '+' => '-']);

        $data = iterator_to_array($pipe->pipe(
            [
                'f.o.o@bar.com',
                'f+o+o@bar.com',
            ]
        ));

        self::assertSame(
            [
                'f.o.o@bar.com',
                'f:o:o@bar.com',
                'f+o+o@bar.com',
                'f-o-o@bar.com',
            ],
            $data
        );
    }
}
