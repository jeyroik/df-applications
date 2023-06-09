<?php
namespace deflou\components\applications\packages;

/**
 * Implements deflou\interfaces\applications\packages\IHaveItem
 * 
 * @property array $config
 */
trait THasItem
{
    public function getItem(string $name): array
    {
        return $this->config[$name] ?? [];
    }
}
