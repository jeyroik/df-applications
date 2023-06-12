<?php
namespace deflou\interfaces\applications\events;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use deflou\interfaces\applications\params\IHaveValue;

interface IEventParam extends IItem, IHasName, IHasDescription, IHaveValue
{
    public const SUBJECT = 'deflou.application.event.param';

    public const FIELD__COMPARES = 'compares';

    public function getCompares(): array;
}
