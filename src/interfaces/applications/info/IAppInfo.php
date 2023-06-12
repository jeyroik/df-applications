<?php
namespace deflou\interfaces\applications\info;

use deflou\interfaces\applications\IHaveApplication;
use deflou\interfaces\applications\vendors\IHaveVendor;
use extas\interfaces\IHasCreatedAt;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;

interface IAppInfo extends IItem, IHaveApplication, IHaveVendor, IHaveUUID, IHaveInfo, IHasCreatedAt
{
    public const SUBJECT = 'deflou.application.info';

    public const FIELD__INSTANCES_COUNT = 'instances_count';

    public function getInstancesCount(): int;
    public function setInstancesCount(int $count): static;
    public function incInstancesCount(int $inc): static;
}
