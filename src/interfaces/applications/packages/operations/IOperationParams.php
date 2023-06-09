<?php
namespace deflou\interfaces\applications\packages\operations;

use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\IHaveItem;

interface IOperationParams extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.package.operation.params';

    public function buildItem(string $name): IOperationParam;

    /**
     * @return IEventParam[]
     */
    public function buildItems(): array;
}
