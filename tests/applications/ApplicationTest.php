<?php

use deflou\components\applications\AppReader;
use deflou\components\applications\AppWriter;
use deflou\components\applications\EStates;
use deflou\components\applications\options\ETypes;
use deflou\components\applications\THasApplicationName;
use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\IHaveApplicationName;
use deflou\interfaces\applications\options\IOption;
use deflou\interfaces\applications\options\IOptions;
use deflou\interfaces\applications\vendors\IVendor;
use extas\components\Item;
use extas\interfaces\parameters\IParam;
use extas\interfaces\parameters\IParametred;
use extas\interfaces\parameters\IParametredCollection;
use extas\interfaces\parameters\IParams;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use tests\ExtasTestCase;

/**
 * Class ApplicationPackageTest
 * @author jeyroik <jeyroik@gmail.com>
 */
class ApplicationTest extends ExtasTestCase
{
    public const PATH__SERVICE_JSON = __DIR__ . '/../resources/service.json';
    public const PATH__SERVICE_JSON_2 = __DIR__ . '/../resources/service.2.json';
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

    public function testApplicationPackageBasics()
    {
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
        $this->assertEquals($etalon[IApplication::FIELD__OPTIONS]['login'], $options->getOne('login'));

        $option = $options->buildOne('login');
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
        $this->assertEquals($etalon[IApplication::FIELD__EVENTS]['nothing_event'], $events->getOne('nothing_event'));

        $event = $events->buildOne('nothing_event');
        $this->assertInstanceOf(IParametred::class, $event);
        $this->assertEquals($etalon[IApplication::FIELD__EVENTS]['nothing_event']['params'], $event->getParams());

        $params = $event->buildParams();
        $this->assertInstanceOf(IParams::class, $params);
        $this->assertEquals(
            $etalon[IApplication::FIELD__EVENTS]['nothing_event']['params']['param1'], 
            $params->getOne('param1')
        );

        $param = $params->buildOne('param1');
        $this->assertInstanceOf(IParam::class, $param);

        $params = $params->buildAll();

        foreach ($params as $param) {
            $this->assertInstanceOf(IParam::class, $param);
        }

        $ops = $app->buildOperations();
        $this->assertInstanceOf(IParametredCollection::class, $ops);
        $this->assertEquals($etalon[IApplication::FIELD__OPERATIONS]['nothing_op'], $ops->getOne('nothing_op'));

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

        $tmp = new class extends Item implements IHaveApplicationName {
            use THasApplicationName;
            protected function getSubjectForExtension(): string
            {
                return '';
            }
        };

        $tmp->setApplicationName($app->getName());
        $this->assertEquals($app->getName(), $tmp->getApplicationName());
        $this->assertEquals($app->getId(), $tmp->getApplication()->getId());

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
