<?php
namespace deflou\components\applications\packages;

use extas\components\Item;
use deflou\interfaces\applications\packages\IOperation;
use deflou\interfaces\applications\packages\IOperations;

class Operations extends Item implements IOperations
{
    use THasItem;
    use TBuildItems;

    public function buildItem(string $name): IOperation
    {
        return new Operation($this->getItem($name));
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
