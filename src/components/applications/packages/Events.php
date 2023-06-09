<?php
namespace deflou\components\applications\packages;

use extas\components\Item;
use deflou\interfaces\applications\packages\IEvent;
use deflou\interfaces\applications\packages\IEvents;

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
