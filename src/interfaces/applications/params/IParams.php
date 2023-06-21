<?php
namespace deflou\interfaces\applications\params;

use deflou\interfaces\applications\items\IHaveItem;
use extas\interfaces\IItem;

interface IParams extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.params';

    /**
     * @return IParam[]
     */
    public function buildItems(): array;

    public function buildItem(string $name): ?IParam;
}
