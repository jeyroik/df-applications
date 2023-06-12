<?php
namespace deflou\interfaces\applications\packages;

interface IHaveResolver
{
    public const FIELD__RESOLVER = 'resolver';

    public function getResolver(): string;
    public function setResolver(string $resolverClass): static;
}
