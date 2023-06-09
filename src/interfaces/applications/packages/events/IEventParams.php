<?php
namespace deflou\interfaces\applications\packages\events;

use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\IHaveItem;

interface IEventParams extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.package.event.params';

    public function buildItem(string $name): IEventParam;

    /**
     * @return IEventParam[]
     */
    public function buildItems(): array;
}
