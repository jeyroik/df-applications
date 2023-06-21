<?php
namespace deflou\interfaces\instances;

use deflou\interfaces\applications\IHaveApplication;
use deflou\interfaces\applications\info\IHaveInfo;
use extas\interfaces\IHasCreatedAt;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;

interface IInstanceInfo extends IItem, IHasCreatedAt, IHaveUUID, IHaveApplication, IHaveInfo, IHaveInstance
{
    public const SUBJECT = 'df.instance.info';

    public const FIELD__APPLICATION_VENDOR_NAME = 'avn';
    public const FIELD__INSTANCE_ID = 'iid';
    public const FIELD__INSTANCE_VENDOR_NAME = 'ivn';
    public const FIELD__DELTA = 'delta';

    public function getApplicationVendorName(): string;
    public function getInstanceVendorName(): string;

    public function resetDelta(): void;
    public function getDelta(): array;
}
