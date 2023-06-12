<?php
namespace deflou\components\instances;

use deflou\components\applications\info\THasInfo;
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
    use THasInfo {
        incTriggersCount as itc;
        incRequestsCount as irc;
        incExecutionsCount as iec;
        setLastExecutedAt as slea;
    }

    public function setLastExecutedAt(int $timestamp): static
    {
        if (!isset($this->config[static::FIELD__DELTA][static::FIELD__LAST_EXECUTED_AT])) {
            $this->config[static::FIELD__DELTA][static::FIELD__LAST_EXECUTED_AT] = 0;
        }

        $this->config[static::FIELD__DELTA][static::FIELD__LAST_EXECUTED_AT] = $timestamp;

        return $this->slea($timestamp);
    }

    public function incExecutionsCount(int $increment): static
    {
        return $this->incDelta(static::FIELD__EXECUTIONS_COUNT, $increment)->iec($increment);
    }

    public function incRequestsCount(int $increment): static
    {
        return $this->incDelta(static::FIELD__REQUESTS_COUNT, $increment)->irc($increment);
    }

    public function incTriggersCount(int $increment): static
    {
        return $this->incDelta(static::FIELD__TRIGGERS_COUNT, $increment)->itc($increment);
    }

    public function getDelta(): array
    {
        return $this->config[static::FIELD__DELTA] ?? [];
    }

    public function resetDelta(): void
    {
        $this->config[static::FIELD__DELTA] = [];
    }

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

    protected function incDelta(string $field, int $increment): static
    {
        if (!isset($this->config[static::FIELD__DELTA][$field])) {
            $this->config[static::FIELD__DELTA][$field] = 0;
        }

        $this->config[static::FIELD__DELTA][$field] += $increment;

        return $this;
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
