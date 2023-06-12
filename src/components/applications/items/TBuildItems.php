<?php
namespace deflou\components\applications\items;

/**
 * @property array $config
 */
trait TBuildItems
{
    public function buildItems(): array
    {
        $result = [];

        foreach ($this->config as $itemName => $itemOptions) {
            $result[$itemName] = $this->buildItem($itemName);
        }

        return $result;
    }
}