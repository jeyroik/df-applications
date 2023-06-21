<?php
namespace deflou\interfaces\applications\params;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;

interface IParametred extends IItem, IHasName, IHasDescription, IHaveParams
{
    public const SUBJECT = 'deflou.parametred';
}
