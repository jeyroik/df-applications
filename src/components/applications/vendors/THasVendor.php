<?php
namespace deflou\components\applications\vendors;

use deflou\interfaces\applications\vendors\IVendor;
use deflou\interfaces\applications\vendors\IHaveVendor;

/**
 * @property array $config
 */
trait THasVendor
{
    public function getVendor(): array
    {
        return $this->config[IHaveVendor::FIELD__VENDOR] ?? '';
    }

    public function buildVendor(): IVendor
    {
        return new Vendor($this->getVendor());
    }
}
