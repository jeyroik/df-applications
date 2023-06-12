<?php
namespace deflou\components\applications\info;

use deflou\interfaces\applications\info\IHaveInfo;

/**
 * @property array $config
 */
trait THasInfo
{
    public function getTriggersCount(): int
    {
        return $this->config[IHaveInfo::FIELD__TRIGGERS_COUNT] ?? 0;
    }

    public function getRequestsCount(): int
    {
        return $this->config[IHaveInfo::FIELD__REQUESTS_COUNT] ?? 0;
    }

    public function getExecutionsCount(): int
    {
        return $this->config[IHaveInfo::FIELD__EXECUTIONS_COUNT] ?? 0;
    }

    public function getLastExecutedAt(): int
    {
        return $this->config[IHaveInfo::FIELD__LAST_EXECUTED_AT] ?? 0;
    }

    public function getRating(): int
    {
        return $this->config[IHaveInfo::FIELD__RATING] ?? 0;
    }

    public function setTriggersCount(int $count): static
    {
        $this->config[IHaveInfo::FIELD__TRIGGERS_COUNT] = $count;

        return $this;
    }

    public function incTriggersCount(int $increment): static
    {
        return $this->setTriggersCount($this->getTriggersCount()+$increment);
    }

    public function setRequestsCount(int $count): static
    {
        $this->config[IHaveInfo::FIELD__REQUESTS_COUNT] = $count;

        return $this;
    }

    public function incRequestsCount(int $increment): static
    {
        return $this->setRequestsCount($this->getRequestsCount()+$increment);
    }

    public function setExecutionsCount(int $count): static
    {
        $this->config[IHaveInfo::FIELD__EXECUTIONS_COUNT] = $count;

        return $this;
    }

    public function incExecutionsCount(int $increment): static
    {
        return $this->setExecutionsCount($this->getExecutionsCount()+$increment);
    }

    public function setLastExecutedAt(int $timestamp): static
    {
        $this->config[IHaveInfo::FIELD__LAST_EXECUTED_AT] = $timestamp;

        return $this;
    }

    public function setRating(int $rating): static
    {
        $this->config[IHaveInfo::FIELD__RATING] = $rating;

        return $this;
    }

    public function incRating(int $increment): static
    {
        return $this->setRating($this->getRating()+$increment);
    }
}
