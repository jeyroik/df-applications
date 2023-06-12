<?php
namespace deflou\components\instances;

use deflou\components\applications\THasApplication;
use deflou\interfaces\instances\IInstance;
use deflou\interfaces\instances\IInstanceInfo;
use extas\components\Item;
use extas\components\THasCreatedAt;
use extas\components\THasStringId;
use extas\interfaces\repositories\IRepository;

/**
 * @method IRepository applications()
 * @method IRepository instances()
 */
class InstanceInfo extends Item implements IInstanceInfo
{
    use THasStringId;
    use THasCreatedAt;
    use THasApplication;

    public function getApplicationVendorName(): string
    {
        return $this->config[static::FIELD__APPLICATION_VENDOR_NAME] ?? '';
    }

    public function getInstanceId(): string
    {
        return $this->config[static::FIELD__INSTANCE_ID] ?? '';
    }

    public function getInstance(): ?IInstance
    {
        return $this->instances()->one([IInstance::FIELD__ID => $this->getInstanceId()]);
    }

    public function getInstanceVendorName(): string
    {
        return $this->config[static::FIELD__INSTANCE_VENDOR_NAME] ?? '';
    }

    public function getTriggerCount(): int
    {
        return $this->config[static::FIELD__TRIGGERS_COUNT] ?? 0;
    }

    public function getRequestsCount(): int
    {
        return $this->config[static::FIELD__REQUESTS_COUNT] ?? 0;
    }

    public function getExecutionsCount(): int
    {
        return $this->config[static::FIELD__EXECUTIONS_COUNT] ?? 0;
    }

    public function getLastExecutedAt(): int
    {
        return $this->config[static::FIELD__LAST_EXECUTED_AT] ?? 0;
    }

    public function getRating(): int
    {
        return $this->config[static::FIELD__RATING] ?? 0;
    }

    public function setApplicationVendorName(string $name): IInstanceInfo
    {
        $this->config[static::FIELD__APPLICATION_VENDOR_NAME] = $name;

        return $this;
    }

    public function setInstanceId(string $id): IInstanceInfo
    {
        $this->config[static::FIELD__INSTANCE_ID] = $id;

        return $this;
    }

    public function setInstanceVendorName(string $name): IInstanceInfo
    {
        $this->config[static::FIELD__INSTANCE_VENDOR_NAME] = $name;

        return $this;
    }

    public function setTriggerCount(int $count): IInstanceInfo
    {
        $this->config[static::FIELD__TRIGGERS_COUNT] = $count;

        return $this;
    }

    public function incTriggerCount(int $increment): IInstanceInfo
    {
        return $this->setTriggerCount($this->getTriggerCount()+$increment);
    }

    public function setRequestsCount(int $count): IInstanceInfo
    {
        $this->config[static::FIELD__REQUESTS_COUNT] = $count;

        return $this;
    }

    public function incRequestsCount(int $increment): IInstanceInfo
    {
        return $this->setRequestsCount($this->getRequestsCount()+$increment);
    }

    public function setExecutionsCount(int $count): IInstanceInfo
    {
        $this->config[static::FIELD__EXECUTIONS_COUNT] = $count;

        return $this;
    }

    public function incExecutionsCount(int $increment): IInstanceInfo
    {
        return $this->setExecutionsCount($this->getExecutionsCount()+$increment);
    }

    public function setLastExecutedAt(int $timestamp): IInstanceInfo
    {
        $this->config[static::FIELD__LAST_EXECUTED_AT] = $timestamp;

        return $this;
    }

    public function setRating(int $rating): IInstanceInfo
    {
        $this->config[static::FIELD__RATING] = $rating;

        return $this;
    }

    public function incRating(int $increment): IInstanceInfo
    {
        return $this->setRating($this->getRating()+$increment);
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
