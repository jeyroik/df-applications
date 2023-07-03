<?php
namespace deflou\components\applications;

use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\IHaveApplicationName;
use extas\interfaces\repositories\IRepository;

/**
 * @method IRepository applications()
 * @property array $config
 */
trait THasApplicationName
{
    public function getApplicationName(): string
    {
        return $this->config[IHaveApplicationName::FIELD__APPLICATION_NAME] ?? '';
    }

    public function getApplication(): ?IApplication
    {
        return $this->applications()->one([IApplication::FIELD__NAME => $this->getApplicationName()]);
    }

    public function setApplicationName(string $name): static
    {
        $this[IHaveApplicationName::FIELD__APPLICATION_NAME] = $name;

        return $this;
    }
}
