<?php

use deflou\components\applications\ApplicationPackageService;
use deflou\components\applications\instances\InstanceService;
use extas\components\repositories\RepoItem;
use extas\components\repositories\TSnuffRepository;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class InstanceTest
 * @author jeyroik <jeyroik@gmail.com>
 */
class InstanceTest extends TestCase
{
    use TSnuffRepository;

    public const PATH__SERVICE_JSON = __DIR__ . '/../resources/service.json';
    public const PATH__INSTALL = __DIR__ . '/../tmp';
    protected array $serviceConfig = [];

    protected function setUp(): void
    {
        putenv("EXTAS__CONTAINER_PATH_STORAGE_LOCK=vendor/jeyroik/extas-foundation/resources/container.dist.json");
        $this->buildBasicRepos();
    }

    protected function tearDown(): void
    {
        $this->dropDatabase(__DIR__);
        $this->deleteRepo('plugins');
        $this->deleteRepo('extensions');
        $this->deleteRepo('application_packages');
        $this->deleteRepo('application_instances');
        $this->deleteRepo('application_instances_info');

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
        $this->buildRepo(__DIR__ . '/../../vendor/jeyroik/extas-foundation/resources/', [
            'application_packages' => [
                "namespace" => "tests\\tmp",
                "item_class" => "deflou\\components\\applications\\ApplicationPackage",
                "pk" => "name",
                "aliases" => ["applicationPackages", "application_packages", "appPackages"],
                "hooks" => [],
                "code" => [
                    'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                    .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
                ]
            ]
        ]);

        $this->buildRepo(__DIR__ . '/../../vendor/jeyroik/extas-foundation/resources/', [
            'application_instances' => [
                "namespace" => "tests\\tmp",
                "item_class" => "deflou\\components\\applications\\instances\\Instance",
                "pk" => "name",
                "aliases" => ["applicationInstances", "application_instances", "appInstances"],
                "hooks" => [],
                "code" => [
                    'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                    .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
                ]
            ]
        ]);

        $this->buildRepo(__DIR__ . '/../../vendor/jeyroik/extas-foundation/resources/', [
            'application_instances_info' => [
                "namespace" => "tests\\tmp",
                "item_class" => "deflou\\components\\applications\\instances\\InstanceInfo",
                "pk" => "name",
                "aliases" => ["applicationInstancesInfo", "application_instances_info", "appInstancesInfo"],
                "hooks" => [],
                "code" => [
                    'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                    .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
                ]
            ]
        ]);

        $appService = new ApplicationPackageService([
            ApplicationPackageService::FIELD__INSTALL_PATH => static::PATH__INSTALL,
            ApplicationPackageService::FIELD__INSTALL_CHECK => false
        ]);
        $package = $appService->createPackageByConfigPath(static::PATH__SERVICE_JSON);

        $instanceService = new InstanceService();
        $instance = $instanceService->createInstanceFromApplication($package, 'jeyroik2');
        $this->assertNotNull($instance);
        $this->assertEquals($package->getResolver(), $instance->getClass());

        $info = $instanceService->getInstanceInfo($instance->getId());
        $this->assertNotNull($info);

        $this->assertEquals($package->getId(), $info->getApplicationId());
        $this->assertNotNull($info->getApplication());
        $this->assertEquals('jeyroik', $info->getApplicationVendorName());
        
        $this->assertEquals($instance->getId(), $info->getInstanceId());
        $this->assertNotNull($info->getInstance());
        $this->assertEquals('jeyroik2', $info->getInstanceVendorName());

        $now = time();

        $info->incTriggerCount(1)->incRequestsCount(2)->incExecutionsCount(3)->incRating(1)->setLastExecutedAt($now);

        $this->assertEquals(1, $info->getTriggerCount());
        $this->assertEquals(2, $info->getRequestsCount());
        $this->assertEquals(3, $info->getExecutionsCount());
        $this->assertEquals(1, $info->getRating());
        $this->assertEquals($now, $info->getLastExecutedAt());

        $info->setApplicationId('id1')->setApplicationVendorName('vendor1')->setInstanceId('id2')->setInstanceVendorName('vendor2');

        $this->assertEquals('id1', $info->getApplicationId());
        $this->assertEquals('id2', $info->getInstanceId());
        $this->assertEquals('vendor1', $info->getApplicationVendorName());
        $this->assertEquals('vendor2', $info->getInstanceVendorName());
    }

    protected function getPackageJsonDecoded(): array
    {
        return empty($this->serviceConfig) 
            ? $this->serviceConfig = json_decode(file_get_contents(static::PATH__SERVICE_JSON), true)
            : $this->serviceConfig;
    }
}
