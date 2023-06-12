<?php
namespace deflou\components\applications\params;

use deflou\interfaces\applications\params\IHaveParams;

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
