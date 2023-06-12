<?php
namespace deflou\components\applications\operations;

use deflou\interfaces\applications\operations\IOperations;
use deflou\interfaces\applications\operations\IHaveOperations;

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
