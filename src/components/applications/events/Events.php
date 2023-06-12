<?php
namespace deflou\components\applications\events;

use deflou\components\applications\items\TBuildItems;
use deflou\components\applications\items\THasItem;
use extas\components\Item;
use deflou\interfaces\applications\events\IEvent;
use deflou\interfaces\applications\events\IEvents;

class Events extends Item implements IEvents
{
    use THasItem;
    use TBuildItems;

    public function buildItem(string $name): IEvent
    {
        return new Event($this->getItem($name));
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
