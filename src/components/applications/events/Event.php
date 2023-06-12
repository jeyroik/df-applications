<?php
namespace deflou\components\applications\events;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use deflou\components\applications\events\EventParams;
use deflou\components\applications\params\THasParams;
use deflou\interfaces\applications\events\IEventParams;
use deflou\interfaces\applications\events\IEvent;

class Event extends Item implements IEvent
{
    use THasName;
    use THasDescription;
    use THasParams;

    public function buildParams(): IEventParams
    {
        return new EventParams($this->getParams());
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
