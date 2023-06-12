<?php
namespace deflou\interfaces\applications\events;

use deflou\interfaces\applications\params\IHaveParams;
use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;

interface IEvent extends IItem, IHasName, IHasDescription, IHaveParams
{
    public const SUBJECT = 'deflou.application.event';

    public function buildParams(): IEventParams;
}
