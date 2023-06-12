<?php
namespace deflou\components\applications\events;

use extas\components\Item;
use deflou\components\applications\items\TBuildItems;
use deflou\components\applications\items\THasItem;
use deflou\interfaces\applications\events\IEventParam;
use deflou\interfaces\applications\events\IEventParams;

class EventParams extends Item implements IEventParams
{
    use THasItem;
    use TBuildItems;

    public function buildItem(string $name): IEventParam
    {
        return new EventParam($this->getItem($name));
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
