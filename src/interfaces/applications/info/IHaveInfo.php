<?php
namespace deflou\interfaces\applications\info;

interface IHaveInfo 
{
    public const FIELD__TRIGGERS_COUNT = 'tc';
    public const FIELD__REQUESTS_COUNT = 'rc';

    /**
     * Only success requests count
     */
    public const FIELD__EXECUTIONS_COUNT = 'ec';
    public const FIELD__LAST_EXECUTED_AT = 'last_executed_at';
    public const FIELD__RATING = 'rating';

    public function getTriggersCount(): int;
    public function getRequestsCount(): int;
    public function getExecutionsCount(): int;
    public function getLastExecutedAt(): int;
    public function getRating(): int;

    public function setTriggersCount(int $count): static;
    public function incTriggersCount(int $increment): static;
    public function setRequestsCount(int $count): static;
    public function incRequestsCount(int $increment): static;
    public function setExecutionsCount(int $count): static;
    public function incExecutionsCount(int $increment): static;
    public function setLastExecutedAt(int $timestamp): static;
    public function setRating(int $rating): static;
    public function incRating(int $increment): static;
}
