<?php
namespace deflou\interfaces\applications\packages;

use extas\interfaces\IItem;

interface IEvents extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.package.events';

    public function buildItem(string $name): IEvent;

    /**
     * @return IEvent[]
     */
    public function buildItems(): array;
}
