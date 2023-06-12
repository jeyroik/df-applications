<?php
namespace deflou\components\applications\resolvers;

use deflou\interfaces\applications\resolvers\IHaveResolver;

/**
 * @property array $config
 */
trait THasResolver
{
    public function getResolver(): string
    {
        return $this->config[IHaveResolver::FIELD__RESOLVER] ?? '';   
    }

    public function setResolver(string $resolverClass): static
    {
        $this->config[IHaveResolver::FIELD__RESOLVER] = $resolverClass;

        return $this;
    }
}
