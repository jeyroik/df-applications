<?php
namespace deflou\components\applications\items;

use deflou\interfaces\applications\items\IHaveItem;

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

    public function getItems(): array
    {
        return $this->config;
    }
}
