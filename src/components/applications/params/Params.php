<?php
namespace deflou\components\applications\params;

use deflou\components\applications\items\THasItem;
use deflou\interfaces\applications\params\IParam;
use deflou\interfaces\applications\params\IParams;
use extas\components\Item;

class Params extends Item implements IParams
{
    use THasItem;

    public function buildItem(string $name): ?IParam
    {
        return new Param($this->getItem($name));
    }

    public function buildItems(): array
    {
        $result = [];

        $items = $this->getItems();
        foreach ($items as $name => $item) {
            $result[$name] = new Param($item);
        }

        return $result;
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
