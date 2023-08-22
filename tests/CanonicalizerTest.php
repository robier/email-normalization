<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test;

use ReflectionProperty;
use Robier\EmailNormalization\Canonicalizer;
use Robier\EmailNormalization\Email;
use Robier\EmailNormalization\Exception;
use Robier\EmailNormalization\Provider;
use PHPUnit\Framework\TestCase;
use Robier\MockGlobalFunction\MockFunction;

/**
 * @covers \Robier\EmailNormalization\Canonicalizer
 */
final class CanonicalizerTest extends TestCase
{
    /**
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::apple()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::fastmail()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::google()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::googleForWork()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::hey()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::microsoft()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::protonMail()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::rackspace()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::rambler()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::yahoo()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::yandex()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::zoho()
     *
     * @runInSeparateProcess
     */
    public function testNormalization(Provider $provider, string $actual, string $expected): void
    {
        $canonicalizer = new Canonicalizer(
            null,
            $provider
        );

        $mock = new MockFunction(
            'Robier\EmailNormalization',
            'getmxrr',
            static function (string $_, array &$hosts): bool {
                $hosts = [
                    'aspmx.l.google.com',
                    'aspmx2.googlemail.com',
                    'aspmx3.googlemail.com',
                    'alt1.aspmx.l.google.com',
                    'alt2.aspmx.l.google.com',
                    'alt3.aspmx.l.google.com',
                    'alt4.aspmx.l.google.com',
                ];

                return true;
            }
        );

        self::assertSame($expected, $canonicalizer->canonize($actual));
    }

    /**
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::apple()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::fastmail()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::google()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::googleForWork()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::hey()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::microsoft()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::protonMail()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::rackspace()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::rambler()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::yahoo()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::yandex()
     * @dataProvider \Robier\EmailNormalization\Test\DomainEmailProvider::zoho()
     *
     * @runInSeparateProcess
     */
    public function testNormalizationWithAllProviders(Provider $_, string $actual, string $expected): void
    {
        $mock = new MockFunction(
            'Robier\EmailNormalization',
            'getmxrr',
            static function (string $_, array &$hosts): bool {
                $hosts = [
                    'aspmx.l.google.com',
                    'aspmx2.googlemail.com',
                    'aspmx3.googlemail.com',
                    'alt1.aspmx.l.google.com',
                    'alt2.aspmx.l.google.com',
                    'alt3.aspmx.l.google.com',
                    'alt4.aspmx.l.google.com',
                ];

                return true;
            }
        );

        $canonicalizer = new Canonicalizer(
            // default
            new Provider\NullMail(),
            // domain providers
            new Provider\Apple(),
            new Provider\Fastmail(),
            new Provider\Google(),
            new Provider\Hey(),
            new Provider\Microsoft(),
            new Provider\ProtonMail(),
            new Provider\Rackspace(),
            new Provider\Rambler(),
            new Provider\Yahoo(),
            new Provider\Yandex(),
            new Provider\Zoho(),
        );

        self::assertSame($expected, $canonicalizer->canonize($actual));
    }

    public function testSettingDefaultProvider(): void
    {
        $provider = new Provider\NullMail();

        $canonicalizer = new Canonicalizer(
            $provider
        );
        $property = new ReflectionProperty($canonicalizer, 'default');
        $property->setAccessible(true);
        $defaultProvider = $property->getValue($canonicalizer);

        self::assertSame($provider, $defaultProvider);
    }

    public function testUsingDefaultProvider(): void
    {
        $canonicalizer = new Canonicalizer(
            new Provider\NullMail()
        );

        $email = 'test+email@gmail.com';

        self::assertSame($email, $canonicalizer->canonize($email));
    }

    public function testExceptionWhenNoDefaultProviderGiven(): void
    {
        $canonicalizer = new Canonicalizer(
            null
        );

        $email = 'test+email@gmail.com';

        self::expectException(Exception::class);
        self::expectExceptionMessage(
            Exception::noProviderFoundFor(Email::fromString($email))->getMessage()
        );

        $canonicalizer->canonize($email);
    }

    /**
     * @runInSeparateProcess
     */
    public function testDefaultProviderIfMailExchangeRecordCanNotBeMatched(): void
    {
        $email = 'test+email@test.com';

        $mock = new MockFunction(
            'Robier\EmailNormalization',
            'getmxrr',
            static function (string $_, array &$hosts): bool {
                return false;
            }
        );

        $canonicalizer = new Canonicalizer(
            new Provider\NullMail(),
            new MailExchangeRecordProvider('mx.foo.bar'),
        );

        self::assertSame($email, $canonicalizer->canonize($email));
    }

    /**
     * @runInSeparateProcess
     */
    public function testMailExchangeRecordProviderSuccess(): void
    {
        $email = 'test+email@test.com';

        $mock = new MockFunction(
            'Robier\EmailNormalization',
            'getmxrr',
            static function (string $_, array &$hosts): bool {
                $hosts = ['mx.foo.bar'];

                return true;
            }
        );

        $canonicalizer = new Canonicalizer(
            null,
            new MailExchangeRecordProvider('mx.foo.bar'),
        );

        self::assertSame($email, $canonicalizer->canonize($email));
    }

    /**
     * @runInSeparateProcess
     */
    public function testMailExchangeRecordProviderFail(): void
    {
        $email = 'test+email@test.com';

        $mock = new MockFunction(
            'Robier\EmailNormalization',
            'getmxrr',
            static function (string $_, array &$hosts): bool {
                return false;
            }
        );

        $canonicalizer = new Canonicalizer(
            null,
            new MailExchangeRecordProvider('bla.com'),
        );

        self::expectException(Exception::class);
        self::expectExceptionMessage(
            Exception::noProviderFoundFor(
                Email::fromString($email)
            )->getMessage()
        );

        $canonicalizer->canonize($email);
    }

    /**
     * @runInSeparateProcess
     */
    public function testNoMatchingMailExchangeRecordProvider(): void
    {
        $email = 'test+email@test.com';

        $mock = new MockFunction(
            'Robier\EmailNormalization',
            'getmxrr',
            static function (string $_, array &$hosts): bool {
                $hosts = ['mx.foo.bar'];

                return true;
            }
        );

        $canonicalizer = new Canonicalizer(
            null,
            new MailExchangeRecordProvider('bla.com'),
        );

        self::expectException(Exception::class);
        self::expectExceptionMessage(
            Exception::noProviderFoundFor(
                Email::fromString($email)
            )->getMessage()
        );

        $canonicalizer->canonize($email);
    }

    /**
     * @runInSeparateProcess
     */
    public function testNoMatchingMailExchangeRecordProviderSoUseDefaultProvider(): void
    {
        $email = 'test+email@test.com';

        $mock = new MockFunction(
            'Robier\EmailNormalization',
            'getmxrr',
            static function (string $_, array &$hosts): bool {
                $hosts = ['mx.foo.bar'];

                return true;
            }
        );

        $canonicalizer = new Canonicalizer(
            new Provider\NullMail(),
            new MailExchangeRecordProvider('bla.com'),
        );

        self::assertSame('test+email@test.com', $canonicalizer->canonize($email));
    }
}
