<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Feature;

use Generator;
use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Feature\NormalizeHost;
use Robier\EmailNormalization\Feature\SubDomainAddressing;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Feature\NormalizeHost
 */
final class NormalizeHostTest extends TestCase
{
    public function dataProvider(): Generator
    {
        yield 'replace domain' => ['bar@foo.com', 'bar@test.com'];
        yield 'replace domain with subdomain' => ['bar@test.foo.com', 'bar@test.com'];
    }

    /**
     * @dataProvider dataProvider()
     */
    public function testFeature(string $test, string $expected): void
    {
        $feature = new NormalizeHost('test.com');

        $emailObject = Email::fromString($test);

        self::assertSame(
            (string)$feature->handle($emailObject),
            $expected
        );
    }
}
