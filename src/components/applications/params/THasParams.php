<?php
namespace deflou\components\applications\params;

use deflou\interfaces\applications\params\IHaveParams;
use deflou\interfaces\applications\params\IParams;

/**
 * @property array $config
 */
trait THasParams
{
    public function getParams(): array
    {
        return $this->config[IHaveParams::FIELD__PARAMS] ?? [];
    }

    public function buildParams(): IParams
    {
        return new Params($this->getParams());
    }
}
