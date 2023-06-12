<?php
namespace deflou\interfaces\applications\operations;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use deflou\interfaces\applications\operations\IOperationParams;
use deflou\interfaces\applications\params\IHaveParams;

interface IOperation extends IItem, IHasName, IHasDescription, IHaveParams
{
    public const SUBJECT = 'deflou.application.operation';

    public function buildParams(): IOperationParams;
}
