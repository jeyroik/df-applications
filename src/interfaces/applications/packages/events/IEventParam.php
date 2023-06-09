<?php
namespace deflou\interfaces\applications\packages\events;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\params\IHaveValue;

interface IEventParam extends IItem, IHasName, IHasDescription, IHaveValue
{
    public const SUBJECT = 'deflou.application.package.event.param';

    public const FIELD__COMPARES = 'compares';

    public function getCompares(): array;
}
