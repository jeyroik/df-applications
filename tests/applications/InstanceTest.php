<?php

use deflou\components\applications\AppWriter;
use deflou\components\instances\InstanceService;
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
        $this->deleteRepo('applications');
        $this->deleteRepo('instances');
        $this->deleteRepo('instances_info');

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
            'applications' => [
                "namespace" => "tests\\tmp",
                "item_class" => "deflou\\components\\applications\\Application",
                "pk" => "name",
                "aliases" => ["applications", "apps"],
                "hooks" => [],
                "code" => [
                    'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                    .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
                ]
            ]
        ]);

        $this->buildRepo(__DIR__ . '/../../vendor/jeyroik/extas-foundation/resources/', [
            'instances' => [
                "namespace" => "tests\\tmp",
                "item_class" => "deflou\\components\\instances\\Instance",
                "pk" => "name",
                "aliases" => ["instances"],
                "hooks" => [],
                "code" => [
                    'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                    .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
                ]
            ]
        ]);

        $this->buildRepo(__DIR__ . '/../../vendor/jeyroik/extas-foundation/resources/', [
            'instances_info' => [
                "namespace" => "tests\\tmp",
                "item_class" => "deflou\\components\\instances\\InstanceInfo",
                "pk" => "name",
                "aliases" => ["instancesInfo", "instances_info", "instancesInfo"],
                "hooks" => [],
                "code" => [
                    'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                    .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'name\']);'
                ]
            ]
        ]);

        $writer = new AppWriter([
            AppWriter::FIELD__INSTALL_PATH => static::PATH__INSTALL,
            AppWriter::FIELD__INSTALL_CHECK => false
        ]);
        $app = $writer->createAppByConfigPath(static::PATH__SERVICE_JSON);

        $instanceService = new InstanceService();
        $instance = $instanceService->createInstanceFromApplication($app, 'jeyroik2');
        $this->assertNotNull($instance);
        $this->assertEquals($app->getResolver(), $instance->getClass());

        $info = $instanceService->getInstanceInfo($instance->getId());
        $this->assertNotNull($info);

        $this->assertEquals($app->getId(), $info->getApplicationId());
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

        $instances = $instanceService->getInstancesByApp($app->getId(), ['jeyroik2']);
        $this->assertCount(1, $instances);

        $grouped = $instanceService->groupInstancesByApp($instances);

        $this->assertArrayHasKey($app->getId(), $grouped);
        $this->assertCount(1, $grouped[$app->getId()]);
    }
}
