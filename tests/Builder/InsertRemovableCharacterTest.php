<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Builder;

use Robier\EmailNormalization\Builder\InsertRemovableCharacter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Builder\InsertRemovableCharacter
 */
final class InsertRemovableCharacterTest extends TestCase
{
    public function testPipe(): void
    {
        $pipe = new InsertRemovableCharacter('.', '+', '_');

        $data = iterator_to_array($pipe->pipe(['foo@bar.com']));

        self::assertSame(
            [
                'foo@bar.com',
                'f.o.o@bar.com',
                'f+o+o@bar.com',
                'f_o_o@bar.com',
            ],
            $data
        );
    }
}
