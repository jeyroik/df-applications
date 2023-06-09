<?php
namespace deflou\interfaces\applications\packages\params;

use extas\interfaces\IHasType;
use extas\interfaces\IHasValue;
use extas\interfaces\IItem;

interface IParamValue extends IItem, IHasValue, IHasType
{
    public const SUBJECT = 'deflou.application.package.param.value';
}
