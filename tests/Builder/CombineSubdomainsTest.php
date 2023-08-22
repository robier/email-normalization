<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Builder;

use Robier\EmailNormalization\Builder\NameToSubdomain;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Builder\NameToSubdomain
 */
final class CombineSubdomainsTest extends TestCase
{
    public function testPipe(): void
    {
        $pipe = new NameToSubdomain('test', 'foo');

        $data = iterator_to_array($pipe->pipe(['foo@bar.com']));

        self::assertSame(
            [
                'foo@bar.com',
                'test@foo.bar.com',
                'foo@foo.bar.com',
            ],
            $data,
        );
    }
}
