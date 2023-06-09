<?php
namespace deflou\interfaces\applications\packages;

use extas\interfaces\IItem;

interface IOperations extends IItem, IHaveItem
{
    public const SUBJECT = 'deflou.application.package.operations';

    public function buildItem(string $name): IOperation;
    
    /**
     * @return IOperation[]
     */
    public function buildItems(): array;
}
