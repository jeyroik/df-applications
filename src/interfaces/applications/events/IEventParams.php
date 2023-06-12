<?php
namespace deflou\interfaces\applications\events;

use deflou\interfaces\applications\items\IHaveItem;
use extas\interfaces\IItem;

interface IEventParams extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.event.params';

    public function buildItem(string $name): IEventParam;

    /**
     * @return IEventParam[]
     */
    public function buildItems(): array;
}
