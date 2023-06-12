<?php
namespace deflou\components\applications\operations;

use extas\components\Item;
use deflou\components\applications\items\TBuildItems;
use deflou\components\applications\items\THasItem;
use deflou\interfaces\applications\operations\IOperationParam;
use deflou\interfaces\applications\operations\IOperationParams;

class OperationParams extends Item implements IOperationParams
{
    use THasItem;
    use TBuildItems;

    public function buildItem(string $name): IOperationParam
    {
        return new OperationParam($this->getItem($name));
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
