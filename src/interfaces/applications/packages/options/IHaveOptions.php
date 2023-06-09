<?php
namespace deflou\interfaces\applications\packages\options;

use deflou\interfaces\applications\packages\IOptions;

interface IHaveOptions
{
    public const FIELD__OPTIONS = 'options';

    public function getOptions(): array;
    public function buildOptions(): IOptions;
}
