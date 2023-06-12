<?php
namespace deflou\interfaces\applications\operations;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use deflou\interfaces\applications\params\IHaveValue;

interface IOperationParam extends IItem, IHasName, IHasDescription, IHaveValue
{
    public const SUBJECT = 'deflou.application.operation.param';
}
