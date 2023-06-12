<?php
namespace deflou\components\applications\operations;

use deflou\components\applications\items\TBuildItems;
use deflou\components\applications\items\THasItem;
use extas\components\Item;
use deflou\interfaces\applications\operations\IOperation;
use deflou\interfaces\applications\operations\IOperations;

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
