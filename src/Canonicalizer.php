<?php

declare(strict_types=1);

namespace Robier\EmailNormalization;

use ReflectionClass;
use Robier\EmailNormalization\Feature\Contract;

final class Canonicalizer
{
    /** @var array<array-key, array<Provider>> */
    private array $providers = [
        'domains' => [],
        'mx-records' => [],
        'features' => [],
    ];

    private ?Provider $default = null;

    public function __construct(Provider $default = null, Provider ...$providers)
    {
        if ($default !== null) {
            array_unshift($providers, $default);

            $this->default = $default;
        }

        foreach ($providers as $provider) {
            if ($provider instanceof DomainProvider) {
                foreach ($provider->domains() as $domain) {
                    $this->providers['domains'][$domain] = $provider;
                }
            }

            if ($provider instanceof MailExchangeRecordProvider) {
                foreach ($provider->records() as $record) {
                    $this->providers['mx-records'][$record] = $provider;
                }
            }

            $this->cacheProviderAttributes($provider);
        }
    }

    private function cacheProviderAttributes(Provider $provider): void
    {
        $reflection = new ReflectionClass($provider);
        $reflectionAttributes = $reflection->getAttributes();

        $this->providers['features'][$provider::class] = [
            'domains' => [],
            'mx-records' => [],
        ];

        // resolve
        $classAttributes = $this->resolveAttributes(...$reflectionAttributes);

        if ($provider instanceof DomainProvider) {
            $this->providers['features'][$provider::class]['domains'] = [
                ...$classAttributes,
                ...$this->resolveAttributes(
                    ...$reflection->getMethod('domains')->getAttributes()
                )
            ];
        }

        if ($provider instanceof MailExchangeRecordProvider) {
            $this->providers['features'][$provider::class]['mx-records'] = [
                ...$classAttributes,
                ...$this->resolveAttributes(
                    ...$reflection->getMethod('records')->getAttributes()
                )
            ];
        }
    }

    private function resolveAttributes(\ReflectionAttribute... $attributes): array
    {
        return array_map(
            function(\ReflectionAttribute $attribute) {
                return $attribute->newInstance();
            },
            $attributes
        );
    }

    /**
     * @throws Exception
     */
    public function canonize(string $email): string
    {
        $email = Email::fromString($email);

        $domains = $this->resolveDomains($email);

        foreach($domains as $domain) {
            if (isset($this->providers['domains'][$domain])) {
                return (string)$this->normalize(
                    $this->providers['domains'][$domain],
                    new Email(
                        $email->name(),
                        $email->domain(),
                        [
                            'matched-domain' => $domain,
                        ]
                    ),
                    'domains'
                );
            }
        }

        // handle mail exchange records
        $hosts = [];
        if (getmxrr($email->domain(), $hosts) === false) {
            // we did not get any domains form MX records
            if ($this->default === null) {
                throw Exception::noProviderFoundFor($email);
            }

            return (string)$this->normalize($this->default, $email);
        }

        foreach ($hosts as $host) {
            if (isset($this->providers['mx-records'][$host])) {
                return (string)$this->normalize(
                    $this->providers['mx-records'][$host],
                    new Email(
                        $email->name(),
                        $email->domain(),
                        [
                            'matched-mx-record' => $host,
                        ]
                    ),
                    'mx-records'
                );
            }
        }

        if ($this->default === null) {
            throw Exception::noProviderFoundFor($email);
        }

        return (string)$this->normalize($this->default, $email);
    }

    private function resolveDomains(Email $email): array
    {
        // Matches email domains like:
        //      gmail.com
        //      outlook.co.nz
        if (mb_substr_count($email->domain(), '.') === 1) {
            // we are 100% there is no any subdomain
            return [$email->domain()];
        }

        $explodedDomain = explode('.', $email->domain());
        unset($explodedDomain[0]);

        return [
            $email->domain(),
            implode('.', $explodedDomain),
        ];
    }

    private function normalize(Provider $provider, Email $email, ?string $type = null): Email
    {
        if (!isset($this->providers['features'][$provider::class][$type])) {
            return $email;
        }

        foreach ($this->providers['features'][$provider::class][$type] as $handler) {
            if ($handler instanceof Contract) {
                $email = $handler->handle($email);
            }
        }

        return $email;
    }
}
