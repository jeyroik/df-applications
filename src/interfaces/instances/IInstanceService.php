<?php
namespace deflou\interfaces\instances;

use deflou\interfaces\applications\IApplication;
use extas\interfaces\IItem;

interface IInstanceService extends IItem
{
    public const SUBJECT = 'df.instance.service';

    public function createInstanceFromApplication(IApplication $app, string $vendorName): ?IInstance;

    public function getInstancesByVendor(array $vendorNames): array;
    public function getInstanceById(string $id, array $vendorNames = []): ?IInstance;

    public function getInstanceInfo(string $instanceId): ?IInstanceInfo;
    public function updateInstanceInfo(IInstanceInfo $info);
}
