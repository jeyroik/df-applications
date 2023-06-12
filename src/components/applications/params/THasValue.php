<?php
namespace deflou\components\applications\params;

use deflou\interfaces\applications\params\IHaveValue;
use deflou\interfaces\applications\params\IParamValue;

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
