<?php
namespace deflou\components\applications\items;

/**
 * Implements deflou\interfaces\applications\IHaveItem
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
