<?php
namespace deflou\interfaces\applications\instances;

use deflou\interfaces\applications\IApplicationPackage;
use extas\interfaces\IItem;

interface IInstanceService extends IItem
{
    public const SUBJECT = 'df.application.instance.service';

    public function createInstanceFromApplication(IApplicationPackage $app, string $vendorName): ?IInstance;

    public function getInstancesByVendor(array $vendorNames): array;
    public function getInstanceById(string $id, array $vendorNames = []): ?IInstance;

    public function getInstanceInfo(string $instanceId): ?IInstanceInfo;
    public function updateInstanceInfo(IInstanceInfo $info);
}
