<?php
namespace deflou\components\applications\operations;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use deflou\components\applications\params\THasValue;
use deflou\interfaces\applications\operations\IOperationParam;

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
