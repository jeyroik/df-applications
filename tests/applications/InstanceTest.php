<?php

use deflou\components\applications\AppReader;
use deflou\components\applications\AppWriter;
use deflou\components\applications\EStates;
use deflou\components\instances\InstanceService;
use deflou\components\plugins\applications\PluginUpdateAppInfoDelta;
use deflou\components\plugins\applications\PluginUpdateAppInfoInstances;
use deflou\interfaces\instances\IInstance;
use deflou\interfaces\stages\IStageInstanceCreated;
use deflou\interfaces\stages\IStageInstanceInfoUpdated;
use extas\components\extensions\Extension;
use extas\components\plugins\Plugin;
use extas\components\repositories\RepoItem;
use extas\components\repositories\TSnuffRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use tests\ExtasTestCase;
use tests\resources\ExtensionStateTest;
use tests\resources\IExtensionStateTest;

/**
 * Class InstanceTest
 * @author jeyroik <jeyroik@gmail.com>
 */
class InstanceTest extends ExtasTestCase
{
    use TSnuffRepository;

    public const PATH__SERVICE_JSON = __DIR__ . '/../resources/service.json';
    public const PATH__SERVICE_JSON_3 = __DIR__ . '/../resources/service.3.json';
    public const PATH__INSTALL = __DIR__ . '/../tmp';
    protected array $serviceConfig = [];

    protected array $libsToInstall = [
        '' => ['php', 'json']
        //'vendor/lib' => ['php', 'json'] storage ext, extas ext
    ];
    protected bool $isNeedInstallLibsItems = true;
    protected string $testPath = __DIR__;

    protected function tearDown(): void
    {
        parent::tearDown();

        $finder = new Finder();
        $finder->name('composer.*');
        foreach ($finder->in(__DIR__ . '/../tmp/')->files() as $file) {
            unlink($file->getRealPath());
        }

        if (is_dir(__DIR__ . '/../tmp/vendor')){
            $fs = new Filesystem();
            $fs->remove([__DIR__ . '/../tmp/vendor']);
        }
    }

    public function testInstanceService()
    {
        $writer = new AppWriter([
            AppWriter::FIELD__INSTALL_PATH => static::PATH__INSTALL,
            AppWriter::FIELD__INSTALL_CHECK => false
        ]);

        $writer->extensions()->create(new Extension([
            Extension::FIELD__CLASS => ExtensionStateTest::class,
            Extension::FIELD__SUBJECT => EStates::SUBJECT,
            Extension::FIELD__INTERFACE => IExtensionStateTest::class,
            Extension::FIELD__METHODS => ['test']
        ]));
        $app = $writer->createAppByConfigPath(static::PATH__SERVICE_JSON);
        /**
         * @var IExtensionStateTest $state
         */
        $state = EStates::from($app->getState());
        $this->assertTrue($state->test());
        $reader = new AppReader();
        $appInfo = $reader->getAppInfo($app->getId());
        $this->assertNotNull($appInfo);

        $instanceService = new InstanceService();
        $instance = $instanceService->createInstanceFromApplication($app, 'jeyroik2');
        $this->assertNotNull($instance);
        $this->assertEquals($app->getResolver(), $instance->getResolver());

        $this->assertEquals('nothing', $instance->buildOptions()->buildOne('login')->getValue());


        $info = $instanceService->getInstanceInfo($instance->getId());
        $this->assertNotNull($info);

        $this->assertEquals($app->getId(), $info->getApplicationId());
        $this->assertNotNull($info->getApplication());
        $this->assertEquals('jeyroik', $info->getApplicationVendorName());
        
        $this->assertEquals($instance->getId(), $info->getInstanceId());
        $this->assertNotNull($info->getInstance());
        $this->assertEquals('jeyroik2', $info->getInstanceVendorName());

        $now = time();

        $info->incTriggersCount(1)->incRequestsCount(2)->incExecutionsCount(3)->incRating(1)->setLastExecutedAt($now);

        $this->assertEquals(1, $info->getTriggersCount());
        $this->assertEquals(2, $info->getRequestsCount());
        $this->assertEquals(3, $info->getExecutionsCount());
        $this->assertEquals(1, $info->getRating());
        $this->assertEquals($now, $info->getLastExecutedAt());

        $appInfo = $reader->getAppInfo($app->getId());
        $this->assertEquals(1, $appInfo->getInstancesCount());
        $this->assertEquals(0, $appInfo->getTriggersCount());

        $instanceService->updateInstanceInfo($info);
        $appInfo = $reader->getAppInfo($app->getId());
        $this->assertEquals(1, $appInfo->getTriggersCount());

        $updated = $instanceService->updateInstance($instance, [IInstance::FIELD__TITLE => 'updated title'], ['login' => 'updated login']);
        $this->assertTrue($updated);
        $this->assertEquals('updated title', $instance->getTitle());
        $this->assertEquals('updated login', $instance->buildOptions()->buildOne('login')->getValue());

        $info->setApplicationId('id1')->setApplicationVendorName('vendor1')->setInstanceId('id2')->setInstanceVendorName('vendor2');

        $this->assertEquals('id1', $info->getApplicationId());
        $this->assertEquals('id2', $info->getInstanceId());
        $this->assertEquals('vendor1', $info->getApplicationVendorName());
        $this->assertEquals('vendor2', $info->getInstanceVendorName());

        $instances = $instanceService->getInstancesByApp($app->getId(), ['jeyroik2']);
        $this->assertCount(1, $instances);

        $grouped = $instanceService->groupInstancesByApp($instances);

        $this->assertArrayHasKey($app->getId(), $grouped);
        $this->assertCount(1, $grouped[$app->getId()]);

        $writer->updateApp($app->getId(), static::PATH__SERVICE_JSON_3);
        $updated = $instanceService->updateInstanceVersion($instance->getId());
        $this->assertTrue($updated, 'Instance is not updated');

        $instance = $instanceService->getInstanceById($instance->getId());
        $opParams = $instance->buildOperations()->buildOne('nothing_op')->buildParams()->buildAll();
        $this->assertCount(1, $opParams);

        $opParam = array_shift($opParams);
        $this->assertEquals('param2', $opParam->getName());
    }
}
