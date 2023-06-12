<?php
namespace deflou\components\applications\params;

use extas\components\Item;
use extas\components\THasType;
use extas\components\THasValue;
use deflou\interfaces\applications\params\IParamValue;

class ParamValue extends Item implements IParamValue
{
    use THasValue;
    use THasType;

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
