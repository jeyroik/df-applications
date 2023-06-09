<?php
namespace deflou\components\applications\packages\operations;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use deflou\components\applications\packages\params\THasValue;
use deflou\interfaces\applications\packages\operations\IOperationParam;

class OperationParam extends Item implements IOperationParam
{
    use THasName;
    use THasDescription;
    use THasValue;

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
