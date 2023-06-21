<?php
namespace deflou\interfaces\applications\operations;

use deflou\interfaces\applications\params\IParametredCollection;

interface IHaveOperations
{
    public const FIELD__OPERATIONS = 'operations';

    public function getOperations(): array;
    public function buildOperations(): IParametredCollection;
}
