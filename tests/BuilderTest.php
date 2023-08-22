<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test;

use Robier\EmailNormalization\Builder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Robier\EmailNormalization\Builder
 */
final class BuilderTest extends TestCase
{
    public function testPlainBuilder(): void
    {
        $builder = new Builder('foo', ['bar.com']);

        self::assertSame(['foo@bar.com'], iterator_to_array($builder->getIterator()));
    }

    public function testCaseSensitiveFlag(): void
    {
        $builder = new Builder('foo', ['bar.com']);
        $builder->isCaseSensitive();

        self::assertSame(['foo@bar.com', 'FOO@bar.com'], iterator_to_array($builder->getIterator()));
    }

    public function testReplaceMechanism(): void
    {
        $builder = new Builder('foo', ['bar.com']);
        $builder->replaces(['o' => 'b']);

        self::assertSame(['foo@bar.com', 'fbb@bar.com'], iterator_to_array($builder->getIterator()));
    }

    public function testRemoveMechanism(): void
    {
        $builder = new Builder('foo', ['bar.com']);
        $builder->removes('a');

        self::assertSame(
            [
                'foo@bar.com',
                'faoao@bar.com',
            ],
            iterator_to_array($builder->getIterator())
        );
    }

    public function testTagAddressingMechanism(): void
    {
        $builder = new Builder('foo', ['bar.com']);
        $builder->hasTagAddressing('+');

        self::assertSame(
            [
                'foo@bar.com',
                'foo+foo-bar@bar.com',
            ],
            iterator_to_array($builder->getIterator())
        );
    }

    public function testSubdomainAddressingMechanism(): void
    {
        $builder = new Builder('foo', ['bar.com']);
        $builder->hasSubdomainAddressing('test');

        self::assertSame(
            [
                'foo@bar.com',
                'test@foo.bar.com',
            ],
            iterator_to_array($builder->getIterator())
        );
    }

    public function testAll(): void
    {
        $builder = (new Builder('foo', ['bar.com']))
            ->isCaseSensitive(true)
            ->replaces(['o' => 'z'])
            ->removes('a')
            ->hasTagAddressing('+')
            ->hasSubdomainAddressing('test');

        self::assertSame(
            [
                'foo@bar.com',
                'fzz@bar.com',
                'foo+foo-bar@bar.com',
                'fzz+fzz-bar@bar.com',
                'faoao@bar.com',
                'fazaz@bar.com',
                'faoao+foo-bar@bar.com',
                'fazaz+fzz-bar@bar.com',
                'test@foo.bar.com',
                'test+foo-bar@foo.bar.com',
                'test+fzz-bar@foo.bar.com',
                'taeasat@foo.bar.com',
                'taeasat+foo-bar@foo.bar.com',
                'taeasat+fzz-bar@foo.bar.com',
            ],
            iterator_to_array($builder->getIterator())
        );
    }
}
