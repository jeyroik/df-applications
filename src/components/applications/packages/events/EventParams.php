<?php
namespace deflou\components\applications\packages\events;

use extas\components\Item;
use deflou\components\applications\packages\TBuildItems;
use deflou\components\applications\packages\THasItem;
use deflou\interfaces\applications\packages\events\IEventParam;
use deflou\interfaces\applications\packages\events\IEventParams;

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
