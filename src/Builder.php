<?php

declare(strict_types=1);

namespace Robier\EmailNormalization;

use Generator;
use IteratorAggregate;
use Robier\EmailNormalization\Builder\AddTagAddressing;
use Robier\EmailNormalization\Builder\ToUpperCase;
use Robier\EmailNormalization\Builder\CombineNameAndDomains;
use Robier\EmailNormalization\Builder\NameToSubdomain;
use Robier\EmailNormalization\Builder\InsertRemovableCharacter;
use Robier\EmailNormalization\Builder\ReplaceCharacters;

/**
 * @internal
 */
final class Builder implements IteratorAggregate
{
    private string $name;
    private array $possibleDomains;
    private bool $isCaseSensitive = true;
    private array $replaces = [];
    private array $tagAddressing = [];
    private array $removes = [];
    private array $subdomains = [];

    public function __construct(string $name, array $possibleDomains)
    {
        $this->name = $name;
        $this->possibleDomains = $possibleDomains;
    }

    public function isCaseSensitive(bool $value = false): self
    {
        $this->isCaseSensitive = $value;

        return $this;
    }

    public function replaces(array $data): self
    {
        $this->replaces = $data;

        return $this;
    }

    public function removes(string ...$data): self
    {
        $this->removes = $data;

        return $this;
    }

    public function hasTagAddressing(string ...$data): self
    {
        $this->tagAddressing = $data;

        return $this;
    }

    public function hasSubdomainAddressing(string ...$subdomains): self
    {
        $this->subdomains = $subdomains;

        return $this;
    }

    public function getIterator(): Generator
    {
        $pipe = (new CombineNameAndDomains($this->name, $this->possibleDomains))->pipe();

        if ($this->subdomains) {
            $pipe = (new NameToSubdomain(...$this->subdomains))->pipe($pipe);
        }

        if ($this->removes) {
            $pipe = (new InsertRemovableCharacter(...$this->removes))->pipe($pipe);
        }

        if ($this->tagAddressing) {
            $pipe = (new AddTagAddressing('foo-bar', ...$this->tagAddressing))->pipe($pipe);
        }

        if ($this->isCaseSensitive === false) {
            $pipe = (new ToUpperCase())->pipe($pipe);
        }

        if ($this->replaces) {
            $pipe = (new ReplaceCharacters($this->replaces))->pipe($pipe);
        }

        yield from $pipe;
    }
}
