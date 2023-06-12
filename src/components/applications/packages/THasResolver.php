<?php
namespace deflou\components\applications\packages;

use deflou\interfaces\applications\packages\IHaveResolver;

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
