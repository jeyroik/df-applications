<?php
namespace deflou\interfaces\applications\events;

use deflou\interfaces\applications\items\IHaveItem;
use extas\interfaces\IItem;

interface IEvents extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.events';

    public function buildItem(string $name): IEvent;

    /**
     * @return IEvent[]
     */
    public function buildItems(): array;
}
