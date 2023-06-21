<?php
namespace deflou\components\applications\operations;

use deflou\components\applications\params\ParametredCollection;
use deflou\interfaces\applications\operations\IHaveOperations;
use deflou\interfaces\applications\params\IParametredCollection;

/**
 * @property array $config
 */
trait THasOperations
{
    public function getOperations(): array
    {
        return $this->config[IHaveOperations::FIELD__OPERATIONS] ?? '';
    }

    public function buildOperations(): IParametredCollection
    {
        return new ParametredCollection($this->getOperations());
    }
}
