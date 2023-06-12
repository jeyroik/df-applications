<?php
namespace deflou\interfaces\applications\operations;

interface IHaveOperations
{
    public const FIELD__OPERATIONS = 'operations';

    public function getOperations(): array;
    public function buildOperations(): IOperations;
}
