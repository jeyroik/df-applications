<?php

use deflou\components\applications\AppReader;
use deflou\components\applications\AppWriter;
use deflou\components\applications\EStates;
use deflou\components\applications\options\ETypes;
use deflou\interfaces\applications\events\IEventParam;
use deflou\interfaces\applications\events\IEventParams;
use deflou\interfaces\applications\events\IEvent;
use deflou\interfaces\applications\events\IEvents;
use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\operations\IOperation;
use deflou\interfaces\applications\operations\IOperations;
use deflou\interfaces\applications\options\IOption;
use deflou\interfaces\applications\options\IOptions;
use deflou\interfaces\applications\params\IParam;
use deflou\interfaces\applications\params\IParametred;
use deflou\interfaces\applications\params\IParametredCollection;
use deflou\interfaces\applications\params\IParams;
use deflou\interfaces\applications\vendors\IVendor;
use deflou\interfaces\applications\params\IParamValue;
use extas\components\repositories\RepoItem;
use extas\components\repositories\TSnuffRepository;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class ApplicationPackageTest
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationTest extends TestCase
{
    use TSnuffRepository;

    public const PATH__SERVICE_JSON = __DIR__ . '/../resources/service.json';
    public const PATH__SERVICE_JSON_2 = __DIR__ . '/../resources/service.2.json';
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
        $this->deleteRepo('applications_info');

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

    protected function buildAppRepos()
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
            'applications_info' => [
                "namespace" => "tests\\tmp",
                "item_class" => "deflou\\components\\applications\\info\\AppInfo",
                "pk" => "id",
                "aliases" => ["applications_inof", "appInfo"],
                "hooks" => [],
                "code" => [
                    'create-before' => '\\' . RepoItem::class . '::setId($item);'
                                    .'\\' . RepoItem::class . '::throwIfExist($this, $item, [\'aid\']);'
                ]
            ]
        ]);
    }

    public function testApplicationPackageBasics()
    {
        $this->buildAppRepos();

        $reader = new AppReader([
            AppReader::FIELD__INSTALL_PATH => static::PATH__INSTALL
        ]);
        $writer = new AppWriter([
            AppWriter::FIELD__INSTALL_PATH => static::PATH__INSTALL,
            AppWriter::FIELD__INSTALL_CHECK => false
        ]);
        $app = $writer->createAppByConfigPath(static::PATH__SERVICE_JSON);

        $this->assertNotNull($app);
        $this->assertEquals('jeyroik/df-test-service:0.*', $app->getPackage());
        $this->assertEquals('test-service', $app->getName());
        $this->assertEquals('https://img.funcraft.ru/edu.png', $app->getAvatar());

        $etalon = $this->getAppJsonDecoded();

        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS], $app->getOptions());
        $this->assertEquals($etalon[IApplication::FIELD__EVENTS], $app->getEvents());
        $this->assertEquals($etalon[IApplication::FIELD__OPERATIONS], $app->getOperations());
        $this->assertEquals($etalon[IApplication::FIELD__VENDOR], $app->getVendor());

        $options = $app->buildOptions();
        $this->assertInstanceOf(IOptions::class, $options);
        $this->assertEquals($etalon[IApplication::FIELD__RESOLVER], $app->getResolver());
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login'], $options->getItem('login'));

        $option = $options->buildItem('login');
        $this->assertInstanceOf(IOption::class, $option);
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login']['default'], $option->getDefault());
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login']['required'], $option->getRequired());
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login']['required'], $option->isRequired());
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login']['encode'], $option->getEncode());
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login']['encode'], $option->isNeedToEncode());
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login']['hashing'], $option->getHashing());
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login']['hashing'], $option->isNeedToHash());

        $events = $app->buildEvents();
        $this->assertInstanceOf(IParametredCollection::class, $events);
        $this->assertEquals($etalon[IApplication::FIELD__EVENTS]['nothing_event'], $events->getItem('nothing_event'));

        $event = $events->buildItem('nothing_event');
        $this->assertInstanceOf(IParametred::class, $event);
        $this->assertEquals($etalon[IApplication::FIELD__EVENTS]['nothing_event']['params'], $event->getParams());

        $params = $event->buildParams();
        $this->assertInstanceOf(IParams::class, $params);
        $this->assertEquals(
            $etalon[IApplication::FIELD__EVENTS]['nothing_event']['params']['param1'], 
            $params->getItem('param1')
        );

        $param = $params->buildItem('param1');
        $this->assertInstanceOf(IParam::class, $param);

        $params = $params->buildItems();

        foreach ($params as $param) {
            $this->assertInstanceOf(IParam::class, $param);
        }

        $ops = $app->buildOperations();
        $this->assertInstanceOf(IParametredCollection::class, $ops);
        $this->assertEquals($etalon[IApplication::FIELD__OPERATIONS]['nothing_op'], $ops->getItem('nothing_op'));

        $op = $ops->buildItem('nothing_op');
        $this->assertInstanceOf(IParametred::class, $op);
        $this->assertEquals($etalon[IApplication::FIELD__OPERATIONS]['nothing_op']['params'], $op->getParams());

        $vendor = $app->buildVendor();
        $this->assertInstanceOf(IVendor::class, $vendor);
        $this->assertEquals($etalon[IApplication::FIELD__VENDOR]['contacts'], $vendor->getContacts());

        $byState = $reader->getAppsByState(EStates::Pending, ['jeyroik']);
        $this->assertNotEmpty($byState, 'Can not find packages by state');

        $byId = $reader->getAppById($app->getId(), ['jeyroik']);
        $this->assertNotEmpty($byId, 'Can not find package by id');

        $byVendor = $reader->getAppsByVendor(['jeyroik']);
        $this->assertNotEmpty($byVendor, 'Can not find packages by vendor');

        $grouped = $reader->groupAppsByState($byState);
        $this->assertNotEmpty($grouped[EStates::Pending->value]);

        $this->assertEquals(static::PATH__INSTALL, $writer->getInstallPath());
        $this->assertEquals(false, $writer->needCheckAfterInstall());

        $this->assertTrue($writer->installApp($app->getId()));
        list($installed, $notInstalled) = $reader->checkApps([$app]);
        $this->assertCount(1, $installed);
        $this->assertEmpty($notInstalled);

        $this->assertTrue(ETypes::Text->is(ETypes::Text->value));

        $this->assertTrue($writer->updateApp($app->getId(), static::PATH__SERVICE_JSON_2));

        $this->assertTrue($writer->changeAppStateTo(EStates::Declined, $app->getId()));
        $app = $reader->getAppById($app->getId());
        $this->assertEquals(EStates::Declined->value, $app->getState());

        $info = $reader->getAppInfo($app->getId());
        $this->assertNotNull($info);
        $this->assertEquals(0, $info->getInstancesCount());
        $info->incInstancesCount(1);
        $this->assertEquals(1, $info->getInstancesCount());
        
        $writer->updateAppInfo($info);
        $info = $reader->getAppInfo($app->getId());
        $this->assertEquals(1, $info->getInstancesCount());
    }

    protected function getAppJsonDecoded(): array
    {
        return empty($this->serviceConfig) 
            ? $this->serviceConfig = json_decode(file_get_contents(static::PATH__SERVICE_JSON), true)
            : $this->serviceConfig;
    }
}
