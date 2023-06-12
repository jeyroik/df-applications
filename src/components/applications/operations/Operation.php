<?php
namespace deflou\components\applications\operations;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use deflou\components\applications\operations\OperationParams;
use deflou\components\applications\params\THasParams;
use deflou\interfaces\applications\operations\IOperation;
use deflou\interfaces\applications\operations\IOperationParams;

class Operation extends Item implements IOperation
{
    use THasName;
    use THasDescription;
    use THasParams;

    public function buildParams(): IOperationParams
    {
        return new OperationParams($this->getParams());
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
