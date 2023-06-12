<?php
namespace deflou\interfaces\applications\operations;

use deflou\interfaces\applications\items\IHaveItem;
use extas\interfaces\IItem;

interface IOperations extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.operations';

    public function buildItem(string $name): IOperation;
    
    /**
     * @return IOperation[]
     */
    public function buildItems(): array;
}
