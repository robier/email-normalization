<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Builder;

use Robier\EmailNormalization\Builder\AddTagAddressing;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Builder\AddTagAddressing
 */
final class AddTagAddressingTest extends TestCase
{
    public function testPipe(): void
    {
        $pipe = new AddTagAddressing('tag-addressing', '+');

        $data = iterator_to_array($pipe->pipe(['test@test.com']));

        self::assertSame(
            [
                'test@test.com',
                'test+tag-addressing@test.com',
            ],
            $data
        );
    }
}
