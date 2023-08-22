<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test\Feature;

use Generator;
use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Feature\SubDomainAddressing;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Feature\SubDomainAddressing
 */
final class SubDomainAddressingTest extends TestCase
{
    public function dataProvider(): Generator
    {
        yield 'without meta and subdomain' => ['foo-bar@test.com', 'foo-bar@test.com', []];
        yield 'without meta and with subdomain' => ['foo-bar@foo.test.com', 'foo-bar@foo.test.com', []];
        yield 'with wrong meta' => ['foo-bar@test.com', 'foo-bar@test.com', ['test' => 'foo']];
        yield 'with subdomain and match' => ['foo@foo-bar.test.com', 'foo-bar@test.com', ['matched-domain' => 'test.com']];
        yield 'with subdomain, without match' => ['foo@foo-bar.test.com', 'foo@foo-bar.test.com', ['matched-domain' => 'foo.com']];
    }

    /**
     * @dataProvider dataProvider()
     */
    public function testFeature(string $test, string $expected, array $meta): void
    {
        $feature = new SubDomainAddressing();

        $emailObject = Email::fromString($test, $meta);

        self::assertSame(
            (string)$feature->handle($emailObject),
            $expected
        );
    }
}
