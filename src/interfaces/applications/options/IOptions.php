<?php
namespace deflou\interfaces\applications\options;

use deflou\interfaces\applications\items\IHaveItem;
use extas\interfaces\IItem;

interface IOptions extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.options';

    public function buildItem(string $name): IOption;

    /**
     * @return IOption[]
     */
    public function buildItems(): array;
}
