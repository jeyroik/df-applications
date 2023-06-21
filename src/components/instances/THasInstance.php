<?php
namespace deflou\components\instances;
use deflou\interfaces\instances\IHaveInstance;
use deflou\interfaces\instances\IInstance;
use extas\interfaces\repositories\IRepository;

/**
 * @property array $config
 * @method IRepository instances()
 */
trait THasInstance
{
    public function getInstanceId(): string
    {
        return $this->config[IHaveInstance::FIELD__INSTANCE_ID] ?? '';
    }

    public function getInstance(): ?IInstance
    {
        return $this->instances()->one([IInstance::FIELD__ID => $this->getInstanceId()]);
    }

    public function setInstanceId(string $id): static
    {
        $this->config[IHaveInstance::FIELD__INSTANCE_ID] = $id;

        return $this;
    }
}
