<?php
namespace deflou\components\applications\operations;

use deflou\interfaces\applications\operations\IHaveOperations;
use extas\components\parameters\ParametredCollection;
use extas\interfaces\parameters\IParametredCollection;

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
