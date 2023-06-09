<?php
namespace deflou\interfaces\applications\packages\vendors;

use deflou\interfaces\applications\packages\IVendor;

interface IHaveVendor
{
    public const FIELD__VENDOR = 'vendor';

    public function getVendor(): array;
    public function buildVendor(): IVendor;
}
