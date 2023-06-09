<?php
namespace deflou\components\applications\packages;

use extas\components\Item;
use extas\components\THasDescription;
use extas\components\THasName;
use deflou\components\applications\packages\events\EventParams;
use deflou\interfaces\applications\packages\events\IEventParams;
use deflou\interfaces\applications\packages\IEvent;

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
