<?php
namespace deflou\components\applications\packages;

use deflou\interfaces\applications\packages\IHaveParams;

/**
 * @property array $config
 */
trait THasParams
{
    public function getParams(): array
    {
        return $this->config[IHaveParams::FIELD__PARAMS] ?? [];
    }
}
