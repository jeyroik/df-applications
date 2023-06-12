<?php
namespace deflou\components\applications\events;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\components\THasType;
use deflou\components\applications\params\THasValue;
use deflou\interfaces\applications\events\IEventParam;

class EventParam extends Item implements IEventParam
{
    use THasName;
    use THasDescription;
    use THasType;
    use THasValue;

    public function getCompares(): array
    {
        return $this->config[static::FIELD__COMPARES] ?? [];
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
