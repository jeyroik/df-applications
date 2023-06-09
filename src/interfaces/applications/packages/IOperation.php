<?php
namespace deflou\interfaces\applications\packages;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\operations\IOperationParams;

interface IOperation extends IItem, IHasName, IHasDescription, IHaveParams
{
    public const SUBJECT = 'deflou.application.package.operation';

    public function buildParams(): IOperationParams;
}
