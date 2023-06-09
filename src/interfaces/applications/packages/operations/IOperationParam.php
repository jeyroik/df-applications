<?php
namespace deflou\interfaces\applications\packages\operations;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\params\IHaveValue;

interface IOperationParam extends IItem, IHasName, IHasDescription, IHaveValue
{
    public const SUBJECT = 'deflou.application.package.operation.param';
}
