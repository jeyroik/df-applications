<?php
namespace deflou\components\applications\instances;

use deflou\interfaces\applications\IApplicationPackage;
use deflou\interfaces\applications\instances\IInstance;
use deflou\interfaces\applications\instances\IInstanceInfo;
use deflou\interfaces\applications\instances\IInstanceService;
use deflou\interfaces\applications\packages\IVendor;
use extas\components\Item;
use extas\interfaces\repositories\IRepository;
use Ramsey\Uuid\Uuid;

/**
 * @method IRepository applicationInstances()
 * @method IRepository applicationInstancesInfo()
 */
class InstanceService extends Item implements IInstanceService
{
    public function createInstanceFromApplication(IApplicationPackage $app, string $vendorName): ?IInstance
    {
        $data = $app->__toArray();
        $data[IInstance::FIELD__VENDOR] = [IVendor::FIELD__NAME => $vendorName];
        unset($data[IApplicationPackage::FIELD__PACKAGE]);
        unset($data[IApplicationPackage::FIELD__STATE]);

        $instance = new Instance([
            Instance::FIELD__APPLICATION_ID => $app->getId(),
            Instance::FIELD__AVATAR => $app->getAvatar(),
            Instance::FIELD__NAME => $app->getName() . '_' . Uuid::uuid4()->toString(),
            Instance::FIELD__DESCRIPTION => $app->getDescription(),
            Instance::FIELD__TITLE => $app->getTitle(),
            Instance::FIELD__OPTIONS => $app->getOptions(),
            Instance::FIELD__EVENTS => $app->getEvents(),
            Instance::FIELD__OPERATIONS => $app->getOperations(),
            Instance::FIELD__VENDOR => [IVendor::FIELD__NAME => $vendorName],
            Instance::FIELD__CLASS => $app->getResolver()
        ]);

        /**
         * @var IInstance $instance
         */
        $instance = $this->applicationInstances()->create($instance);
        $this->createInstanceInfo($app, $instance);

        return $instance;
    }

    public function getInstancesByVendor(array $vendorNames): array
    {
        return $this->applicationInstances()->all([
            IInstance::FIELD__VENDOR . '.' . IVendor::FIELD__NAME => $vendorNames
        ]);
    }

    public function getInstanceById(string $id, array $vendorNames = []): ?IInstance
    {
        $query = [
            IInstance::FIELD__ID => $id
        ];

        if (!empty($vendorNames)) {
            $query[IInstance::FIELD__VENDOR . '.' . IVendor::FIELD__NAME] = $vendorNames;
        }

        return $this->applicationInstances()->one($query);
    }

    public function getInstanceInfo(string $instanceId): ?IInstanceInfo
    {
        return $this->applicationInstancesInfo()->one([
            IInstanceInfo::FIELD__INSTANCE_ID => $instanceId
        ]);
    }

    public function updateInstanceInfo(IInstanceInfo $info)
    {
        $this->applicationInstancesInfo()->update($info);
    }

    protected function createInstanceInfo(IApplicationPackage $app, IInstance $instance): ?IInstanceInfo
    {
        $info = new InstanceInfo([
            InstanceInfo::FIELD__APPLICATION_ID => $app->getId(),
            InstanceInfo::FIELD__APPLICATION_VENDOR_NAME => $app->buildVendor()->getName(),
            InstanceInfo::FIELD__INSTANCE_ID => $instance->getId(),
            InstanceInfo::FIELD__INSTANCE_VENDOR_NAME => $instance->buildVendor()->getName(),
            InstanceInfo::FIELD__TRIGGERS_COUNT => 0,
            InstanceInfo::FIELD__REQUESTS_COUNT => 0,
            InstanceInfo::FIELD__EXECUTIONS_COUNT => 0,
            InstanceInfo::FIELD__LAST_EXECUTED_AT => 0,
            InstanceInfo::FIELD__RATING => 0,
            InstanceInfo::FIELD__CREATED_AT => time()
        ]);
        $info = $this->applicationInstancesInfo()->create($info);

        return $info;
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
