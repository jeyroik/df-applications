<?php
namespace deflou\interfaces\applications\options;

interface IHaveOptions
{
    public const FIELD__OPTIONS = 'options';

    public function getOptions(): array;
    public function buildOptions(): IOptions;
}
