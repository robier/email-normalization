<?php

declare(strict_types=1);

namespace Robier\EmailNormalization\Test;

use Generator;
use Robier\EmailNormalization\Builder;
use Robier\EmailNormalization\Provider;

final class DomainEmailProvider
{
    public function apple(): Generator
    {
        $provider = new Provider\Apple();
        $builder = new Builder('test', $provider->domains());
        $builder->removes('+');

        $expectedEmail = 'test@icloud.com';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }

    public function fastmail(): Generator
    {
        $provider = new Provider\Fastmail();
        foreach ($provider->domains() as $domain) {
            $builder =
                (new Builder('test', [$domain]))
                    ->hasTagAddressing('+')
                    ->hasSubdomainAddressing('test');

            $expectedEmail = 'test@' . $domain;
            foreach ($builder as $email) {
                yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
            }
        }
    }

    public function google(): Generator
    {
        $provider = new Provider\Google();
        $builder = new Builder('test', $provider->domains());
        $builder->hasTagAddressing('+');
        $builder->removes('.');

        $expectedEmail = 'test@gmail.com';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }

    public function googleForWork(): Generator
    {
        $provider = new Provider\Google();
        $builder = new Builder('sullie', ['fakedomain.com']);
        $builder->hasTagAddressing('+');
        $builder->removes('.');

        $expectedEmail = 'sullie@fakedomain.com';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }

    public function hey(): Generator
    {
        $provider = new Provider\Hey();
        $builder = new Builder('test', $provider->domains());
        $builder->hasTagAddressing('+');

        $expectedEmail = 'test@hey.com';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }

    public function microsoft(): Generator
    {
        $provider = new Provider\Microsoft();
        foreach ($provider->domains() as $domain) {
            $builder = new Builder('test', [$domain]);
            $builder->hasTagAddressing();

            $expectedEmail = 'test@' . $domain;
            foreach ($builder as $email) {
                yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
            }
        }
    }

    public function protonMail(): Generator
    {
        $provider = new Provider\ProtonMail();
        $builder = new Builder('test', $provider->domains());
        $builder->removes('+');

        $expectedEmail = 'test@protonmail.ch';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }

    public function rackspace(): Generator
    {
        $provider = new Provider\Rackspace();
        $builder = new Builder('test', $provider->domains());
        $builder->removes('+');

        $expectedEmail = 'test@emailsrvr.com';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }

    public function rambler(): Generator
    {
        $provider = new Provider\Rambler();
        foreach ($provider->domains() as $domain) {
            $builder = new Builder('test', [$domain]);
            $builder->removes('+');

            $expectedEmail = 'test@' . $domain;
            foreach ($builder as $email) {
                yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
            }
        }
    }

    public function yahoo(): Generator
    {
        $provider = new Provider\Yahoo();
        foreach ($provider->domains() as $domain) {
            $builder = new Builder('test', [$domain]);
            $builder->removes('.')
            ->hasTagAddressing('-');

            $expectedEmail = 'test@' . $domain;
            foreach ($builder as $email) {
                yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
            }
        }
    }

    public function yandex(): Generator
    {
        $provider = new Provider\Yandex();
        $builder = new Builder('t.e.s.t', $provider->domains());
        $builder->hasTagAddressing('+');
        $builder->replaces(['.' => '-']);

        $expectedEmail = 't.e.s.t@yandex.ru';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }

    public function zoho(): Generator
    {
        $provider = new Provider\Zoho();
        $builder = new Builder('test', $provider->domains());
        $builder->removes('+');

        $expectedEmail = 'test@zoho.com';
        foreach ($builder as $email) {
            yield $email . ' -> ' . $expectedEmail => [$provider, $email, $expectedEmail];
        }
    }
}
