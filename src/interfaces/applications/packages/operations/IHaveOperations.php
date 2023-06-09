<?php
namespace deflou\interfaces\applications\packages\operations;

use deflou\interfaces\applications\packages\IOperations;

interface IHaveOperations
{
    public const FIELD__OPERATIONS = 'operations';

    public function getOperations(): array;
    public function buildOperations(): IOperations;
}
