<?php
namespace deflou\interfaces\applications\operations;

use deflou\interfaces\applications\items\IHaveItem;
use extas\interfaces\IItem;

interface IOperationParams extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.operation.params';

    public function buildItem(string $name): IOperationParam;

    /**
     * @return IEventParam[]
     */
    public function buildItems(): array;
}
