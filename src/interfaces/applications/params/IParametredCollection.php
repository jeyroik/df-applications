<?php
namespace deflou\interfaces\applications\params;

use deflou\interfaces\applications\items\IHaveItem;
use extas\interfaces\IItem;

interface IParametredCollection extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.parametred.collection';

    public function buildItem(string $name): ?IParametred;

    /**
     * @return IParametred[]
     */
    public function buildItems(): array;

    public function getItems(): array;
}
