<?php
namespace deflou\interfaces\applications\packages;

use extas\interfaces\IItem;

interface IOptions extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.package.options';

    public function buildItem(string $name): IOption;

    /**
     * @return IOption[]
     */
    public function buildItems(): array;
}
