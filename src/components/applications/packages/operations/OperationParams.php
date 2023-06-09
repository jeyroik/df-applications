<?php
namespace deflou\components\applications\packages\operations;

use extas\components\Item;
use deflou\components\applications\packages\TBuildItems;
use deflou\components\applications\packages\THasItem;
use deflou\interfaces\applications\packages\operations\IOperationParam;
use deflou\interfaces\applications\packages\operations\IOperationParams;

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
