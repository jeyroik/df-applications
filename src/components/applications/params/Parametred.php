<?php
namespace deflou\components\applications\params;

use deflou\interfaces\applications\params\IParametred;
use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;

class Parametred extends Item implements IParametred
{
    use THasName;
    use THasDescription;
    use THasParams;

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
