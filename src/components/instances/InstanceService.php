<?php
namespace deflou\components\instances;

use deflou\components\applications\AppReader;
use deflou\components\applications\AppWriter;
use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\options\IOption;
use deflou\interfaces\instances\IInstance;
use deflou\interfaces\instances\IInstanceInfo;
use deflou\interfaces\instances\IInstanceService;
use deflou\interfaces\applications\vendors\IVendor;
use deflou\interfaces\stages\IStageInstanceCreated;
use deflou\interfaces\stages\IStageInstanceInfoUpdated;
use extas\components\Item;
use extas\interfaces\repositories\IRepository;
use Ramsey\Uuid\Uuid;

/**
 * @method IRepository instances()
 * @method IRepository instancesInfo()
 */
class InstanceService extends Item implements IInstanceService
{
    /**
     * @return IInstance[]
     */
    public function getInstancesByApp(string $appId, array $insVendorNames): array
    {
        $query = [
            IInstance::FIELD__APPLICATION_ID => $appId
        ];

        if (!empty($insVendorNames)) {
            $query[IInstance::FIELD__VENDOR . '.' . IVendor::FIELD__NAME] = $insVendorNames;
        }

        return $this->instances()->all($query);
    }

    public function groupInstancesByApp(array $instances): array
    {
        $insByApp = [];

        foreach ($instances as $ins) {
            if (!isset($insByApp[$ins->getApplicationId()])) {
                $insByApp[$ins->getApplicationId()] = [];
            }

            $insByApp[$ins->getApplicationId()][] = $ins;
        }

        return $insByApp;
    }

    public function createInstanceFromApplication(IApplication $app, string $vendorName): ?IInstance
    {
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
            Instance::FIELD__RESOLVER => $app->getResolver(),
            Instance::FILED__VERSION => $app->getVersion()
        ]);

        /**
         * @var IInstance $instance
         */
        $instance = $this->instances()->create($instance);
        $this->createInstanceInfo($app, $instance);

        foreach ($this->getPluginsByStage(IStageInstanceCreated::NAME) as $plugin) {
            /**
             * @var IStageInstanceCreated $plugin
             */
            $plugin($app, $instance);
        }

        return $instance;
    }

    public function getInstancesByVendor(array $vendorNames): array
    {
        return $this->instances()->all([
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

        return $this->instances()->one($query);
    }

    public function getInstanceInfo(string $instanceId): ?IInstanceInfo
    {
        return $this->instancesInfo()->one([
            IInstanceInfo::FIELD__INSTANCE_ID => $instanceId
        ]);
    }

    public function updateInstanceInfo(IInstanceInfo $info): void
    {
        $this->instancesInfo()->update($info);

        foreach ($this->getPluginsByStage(IStageInstanceInfoUpdated::NAME) as $plugin) {
            /**
             * @var IStageInstanceInfoUpdated $plugin
             */
            $plugin($info);
        }
    }

    public function updateInstanceVersion(string $instanceId): bool
    {
        $instance = $this->getInstanceById($instanceId);
        $app = $instance->getApplication();

        if ($instance->compareVersionTo($app->getVersion(), '>=')) {
            return false;
        }

        $appOptions = $app->getOptions();
        $insOptions = $instance->getOptions();

        foreach ($insOptions as $name => $data) {
            if (!isset($appOptions[$name])) {
                unset($insOptions[$name]);
            }
        }

        foreach ($appOptions as $name => $data) {
            if (!isset($insOptions[$name])) {
                $insOptions[$name] = $data;
            }
        }

        return $this->updateInstance(
            $instance, 
            [
                Instance::FIELD__AVATAR => $app->getAvatar(),
                Instance::FIELD__EVENTS => $app->getEvents(),
                Instance::FIELD__OPERATIONS => $app->getOperations(),
                Instance::FIELD__RESOLVER => $app->getResolver(),
                Instance::FILED__VERSION => $app->getVersion(),
                Instance::FIELD__OPTIONS => $insOptions
            ], 
            []
        );
    }

    public function updateInstance(IInstance &$instance, array $data, array $options): bool
    {
        $srcOptions = $instance->getOptions();
        foreach ($options as $name => $value) {
            if (isset($srcOptions[$name])) {
                $srcOptions[$name][IOption::FIELD__VALUE] = $value;
            }
        }
        
        foreach ($data as $name => $value) {
            if (isset($instance[$name])) {
                $instance[$name] = $value;
            }
        }

        $instance[IInstance::FIELD__OPTIONS] = $srcOptions;

        $updated = $this->instances()->update($instance);

        return $updated ? true : false;
    }

    protected function createInstanceInfo(IApplication $app, IInstance $instance): ?IInstanceInfo
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
        $info = $this->instancesInfo()->create($info);

        return $info;
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
