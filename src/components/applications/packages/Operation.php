<?php
namespace deflou\components\applications\packages;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use deflou\components\applications\packages\operations\OperationParams;
use deflou\interfaces\applications\packages\IOperation;
use deflou\interfaces\applications\packages\operations\IOperationParams;

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
