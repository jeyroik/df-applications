<?php
namespace deflou\interfaces\applications\packages;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\events\IEventParams;

interface IEvent extends IItem, IHasName, IHasDescription, IHaveParams
{
    public const SUBJECT = 'deflou.application.package.event';

    public function buildParams(): IEventParams;
}
