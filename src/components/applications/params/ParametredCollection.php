<?php
namespace deflou\components\applications\params;

use deflou\components\applications\items\TBuildItems;
use deflou\components\applications\items\THasItem;
use deflou\interfaces\applications\params\IParametred;
use deflou\interfaces\applications\params\IParametredCollection;
use extas\components\Item;

class ParametredCollection extends Item implements IParametredCollection
{
    use THasItem;
    use TBuildItems;

    public function buildItem(string $name): ?IParametred
    {
        return new Parametred($this->getItem($name));
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
