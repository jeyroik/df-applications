<?php
namespace deflou\interfaces\applications\packages;

interface IHaveParams
{
    public const FIELD__PARAMS = 'params';

    public function getParams(): array;
}
