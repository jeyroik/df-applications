<?php
namespace deflou\components\applications\packages\params;

use deflou\interfaces\applications\packages\params\IHaveValue;
use deflou\interfaces\applications\packages\params\IParamValue;

/**
 * @property array $config
 */
trait THasValue
{    
    public function getValue(): array
    {
        return $this->config[IHaveValue::FIELD__VALUE] ??[];
    }

    public function buildValue(): IParamValue
    {
        return new ParamValue($this->getValue());
    }
}
