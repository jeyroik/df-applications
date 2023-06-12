<?php
namespace deflou\components\applications;

use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\IHaveApplication;

/**
 * @property array $config
 */
trait THasApplication
{
    public function getApplicationId(): string
    {
        return $this->config[IHaveApplication::FIELD__APPLICATION_ID] ?? '';
    }

    public function getApplication(): ?IApplication
    {
        return $this->applications()->one([IApplication::FIELD__ID => $this->getApplicationId()]);
    }

    public function setApplicationId(string $id): static
    {
        $this->config[IHaveApplication::FIELD__APPLICATION_ID] = $id;

        return $this;
    }
}
