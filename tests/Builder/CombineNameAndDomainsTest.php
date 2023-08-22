<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Builder;

use Robier\EmailNormalization\Builder\CombineNameAndDomains;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Builder\CombineNameAndDomains
 */
final class CombineNameAndDomainsTest extends TestCase
{
    public function testPipe(): void
    {
        $pipe = new CombineNameAndDomains('test', ['foo.com', 'bar.com']);

        $data = iterator_to_array($pipe->pipe());

        self::assertSame(
            [
                'test@foo.com',
                'test@bar.com',
            ],
            $data,
        );
    }
}
