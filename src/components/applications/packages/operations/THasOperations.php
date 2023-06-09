<?php
namespace deflou\components\applications\packages\operations;

use deflou\components\applications\packages\Operations;
use deflou\interfaces\applications\packages\IOperations;
use deflou\interfaces\applications\packages\operations\IHaveOperations;

/**
 * @property array $config
 */
trait THasOperations
{
    public function getOperations(): array
    {
        return $this->config[IHaveOperations::FIELD__OPERATIONS] ?? '';
    }

    public function buildOperations(): IOperations
    {
        return new Operations($this->getOperations());
    }
}
