<?php

use deflou\components\applications\ApplicationPackageService;
use deflou\components\applications\packages\EStates;
use deflou\components\applications\packages\options\ETypes;
use deflou\interfaces\applications\IApplicationPackage;
use deflou\interfaces\applications\packages\events\IEventParam;
use deflou\interfaces\applications\packages\events\IEventParams;
use deflou\interfaces\applications\packages\IEvent;
use deflou\interfaces\applications\packages\IEvents;
use deflou\interfaces\applications\packages\IOperation;
use deflou\interfaces\applications\packages\IOperations;
use deflou\interfaces\applications\packages\IOption;
use deflou\interfaces\applications\packages\IOptions;
use deflou\interfaces\applications\packages\IVendor;
use deflou\interfaces\applications\packages\params\IParamValue;
use extas\components\repositories\RepoItem;
use extas\components\repositories\TSnuffRepository;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class ApplicationPackageTest
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationPackageTest extends TestCase
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

    public function testApplicationPackageBasics()
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

        $appService = new ApplicationPackageService([
            ApplicationPackageService::FIELD__INSTALL_PATH => static::PATH__INSTALL,
            ApplicationPackageService::FIELD__INSTALL_CHECK => false
        ]);
        $package = $appService->createPackageByConfigPath(static::PATH__SERVICE_JSON);

        $this->assertNotNull($package);
        $this->assertEquals('jeyroik/df-test-service:0.*', $package->getPackage());
        $this->assertEquals('test-service', $package->getName());
        $this->assertEquals('https://img.funcraft.ru/edu.png', $package->getAvatar());

        $etalon = $this->getPackageJsonDecoded();

        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS], $package->getOptions());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__EVENTS], $package->getEvents());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPERATIONS], $package->getOperations());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__VENDOR], $package->getVendor());

        $options = $package->buildOptions();
        $this->assertInstanceOf(IOptions::class, $options);
        $this->assertEquals($etalon[IApplicationPackage::FIELD__RESOLVER], $package->getResolver());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login'], $options->getItem('login'));

        $option = $options->buildItem('login');
        $this->assertInstanceOf(IOption::class, $option);
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login']['default'], $option->getDefault());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login']['required'], $option->getRequired());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login']['required'], $option->isRequired());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login']['encode'], $option->getEncode());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login']['encode'], $option->isNeedToEncode());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login']['hashing'], $option->getHashing());
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPTIONS]['login']['hashing'], $option->isNeedToHash());

        $events = $package->buildEvents();
        $this->assertInstanceOf(IEvents::class, $events);
        $this->assertEquals($etalon[IApplicationPackage::FIELD__EVENTS]['nothing_event'], $events->getItem('nothing_event'));

        $event = $events->buildItem('nothing_event');
        $this->assertInstanceOf(IEvent::class, $event);
        $this->assertEquals($etalon[IApplicationPackage::FIELD__EVENTS]['nothing_event']['params'], $event->getParams());

        $params = $event->buildParams();
        $this->assertInstanceOf(IEventParams::class, $params);
        $this->assertEquals(
            $etalon[IApplicationPackage::FIELD__EVENTS]['nothing_event']['params']['param1'], 
            $params->getItem('param1')
        );

        $param = $params->buildItem('param1');
        $this->assertInstanceOf(IEventParam::class, $param);
        $this->assertEquals(
            $etalon[IApplicationPackage::FIELD__EVENTS]['nothing_event']['params']['param1']['compares'], 
            $param->getCompares()
        );
        $this->assertEquals(
            $etalon[IApplicationPackage::FIELD__EVENTS]['nothing_event']['params']['param1']['value'], 
            $param->getValue()
        );

        $value = $param->buildValue();
        $this->assertInstanceOf(IParamValue::class, $value);

        $params = $params->buildItems();

        foreach ($params as $param) {
            $this->assertInstanceOf(IEventParam::class, $param);
        }

        $ops = $package->buildOperations();
        $this->assertInstanceOf(IOperations::class, $ops);
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPERATIONS]['nothing_op'], $ops->getItem('nothing_op'));

        $op = $ops->buildItem('nothing_op');
        $this->assertInstanceOf(IOperation::class, $op);
        $this->assertEquals($etalon[IApplicationPackage::FIELD__OPERATIONS]['nothing_op']['params'], $op->getParams());

        $vendor = $package->buildVendor();
        $this->assertInstanceOf(IVendor::class, $vendor);
        $this->assertEquals($etalon[IApplicationPackage::FIELD__VENDOR]['contacts'], $vendor->getContacts());

        $byState = $appService->getPackagesByState(EStates::Pending, ['jeyroik']);
        $this->assertNotEmpty($byState, 'Can not find packages by state');

        $byId = $appService->getPackageById($package->getId(), ['jeyroik']);
        $this->assertNotEmpty($byId, 'Can not find package by id');

        $byVendor = $appService->getPackagesByVendor(['jeyroik']);
        $this->assertNotEmpty($byVendor, 'Can not find packages by vendor');

        $grouped = $appService->groupPackagesByState($byState);
        $this->assertNotEmpty($grouped[EStates::Pending->value]);

        $this->assertEquals(static::PATH__INSTALL, $appService->getInstallPath());
        $this->assertEquals(false, $appService->needCheckAfterInstall());

        $this->assertTrue($appService->installPackage($package->getId()));
        list($installed, $notInstalled) = $appService->checkPackages([$package]);
        $this->assertCount(1, $installed);
        $this->assertEmpty($notInstalled);

        $this->assertTrue(ETypes::Text->is(ETypes::Text->value));
    }

    protected function getPackageJsonDecoded(): array
    {
        return empty($this->serviceConfig) 
            ? $this->serviceConfig = json_decode(file_get_contents(static::PATH__SERVICE_JSON), true)
            : $this->serviceConfig;
    }
}
