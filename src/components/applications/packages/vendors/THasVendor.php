<?php
namespace deflou\components\applications\packages\vendors;

use deflou\components\applications\packages\Vendor;
use deflou\interfaces\applications\packages\IVendor;
use deflou\interfaces\applications\packages\vendors\IHaveVendor;

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
