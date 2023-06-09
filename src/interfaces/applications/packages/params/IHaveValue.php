<?php
namespace deflou\interfaces\applications\packages\params;

interface IHaveValue
{
    public const FIELD__VALUE = 'value';

    public function getValue(): array;
    public function buildValue(): IParamValue;
}
