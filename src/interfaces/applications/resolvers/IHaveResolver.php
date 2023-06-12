<?php
namespace deflou\interfaces\applications\resolvers;

interface IHaveResolver
{
    public const FIELD__RESOLVER = 'resolver';

    public function getResolver(): string;
    public function setResolver(string $resolverClass): static;
}
