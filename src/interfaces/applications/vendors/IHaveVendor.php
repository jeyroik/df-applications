<?php
namespace deflou\interfaces\applications\vendors;

interface IHaveVendor
{
    public const FIELD__VENDOR = 'vendor';

    public function getVendor(): array;
    public function buildVendor(): IVendor;
}
