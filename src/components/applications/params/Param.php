<?php
namespace deflou\components\applications\params;

use deflou\interfaces\applications\params\IParam;
use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;

class Param extends Item implements IParam
{
    use THasName;
    use THasDescription;
    
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
