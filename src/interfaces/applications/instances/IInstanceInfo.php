<?php
namespace deflou\interfaces\applications\instances;

use deflou\interfaces\applications\IApplicationPackage;
use deflou\interfaces\applications\IHaveApplication;
use extas\interfaces\IHasCreatedAt;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;

interface IInstanceInfo extends IItem, IHasCreatedAt, IHaveUUID, IHaveApplication
{
    public const SUBJECT = 'df.application.instance.info';

    public const FIELD__APPLICATION_VENDOR_NAME = 'avn';

    public const FIELD__INSTANCE_ID = 'iid';
    public const FIELD__INSTANCE_VENDOR_NAME = 'ivn';

    public const FIELD__TRIGGERS_COUNT = 'tc';
    public const FIELD__REQUESTS_COUNT = 'ec';

    /**
     * Only success requests count
     */
    public const FIELD__EXECUTIONS_COUNT = 'ec';
    public const FIELD__LAST_EXECUTED_AT = 'last_executed_at';
    public const FIELD__RATING = 'rating';

    public function getApplicationVendorName(): string;

    public function getInstanceId(): string;
    public function getInstance(): ?IInstance;
    public function getInstanceVendorName(): string;

    public function getTriggerCount(): int;
    public function getRequestsCount(): int;
    public function getExecutionsCount(): int;
    public function getLastExecutedAt(): int;
    public function getRating(): int;

    public function setApplicationVendorName(string $name): self;
    public function setInstanceId(string $id): self;
    public function setInstanceVendorName(string $name): self;
    public function setTriggerCount(int $count): self;
    public function incTriggerCount(int $increment): self;
    public function setRequestsCount(int $count): self;
    public function incRequestsCount(int $increment): self;
    public function setExecutionsCount(int $count): self;
    public function incExecutionsCount(int $increment): self;
    public function setLastExecutedAt(int $timestamp): self;
    public function setRating(int $rating): self;
    public function incRating(int $increment): self;
}
