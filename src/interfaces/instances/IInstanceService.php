<?php
namespace deflou\interfaces\instances;

use deflou\interfaces\applications\IApplication;
use extas\interfaces\IItem;

interface IInstanceService extends IItem
{
    public const SUBJECT = 'df.instance.service';

    public function createInstanceFromApplication(IApplication $app, string $vendorName): ?IInstance;

    /**
     * @return IInstance[]
     */
    public function getInstancesByVendor(array $vendorNames): array;

    /**
     * @return IInstance[]
     */
    public function getInstancesByApp(string $appId, array $insVendorNames): array;

    /**
     * @param IInstance[] $instances
     * 
     * @return array [<app.id> => [<instance>, ...], ...]
     */
    public function groupInstancesByApp(array $instances): array;
    public function getInstanceById(string $id, array $vendorNames = []): ?IInstance;

    public function getInstanceInfo(string $instanceId): ?IInstanceInfo;

    /**
     * @stage deflou.instance.info.updated
     */
    public function updateInstanceInfo(IInstanceInfo $info): void;

    public function updateInstance(IInstance &$instance, array $data, array $options): bool;
}
