<?php
namespace deflou\interfaces\applications\params;

interface IHaveParams
{
    public const FIELD__PARAMS = 'params';

    public function getParams(): array;
}
