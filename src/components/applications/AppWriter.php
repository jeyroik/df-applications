<?php
namespace deflou\components\applications;

use Composer\Command\RequireCommand;
use Composer\Console\Application;
use deflou\components\applications\Application as DeflouApplication;
use extas\components\Item;
use extas\interfaces\IHasState;
use extas\interfaces\repositories\IRepository;
use deflou\components\applications\EStates;
use deflou\components\applications\info\AppInfo;
use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\IAppWriter;
use deflou\interfaces\applications\info\IAppInfo;
use extas\components\commands\GenerateCommand;
use extas\components\commands\InstallCommand;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method IRepository applications()
 * @method IRepository appInfo()
 */
class AppWriter extends Item implements IAppWriter
{
    use THasInstallPath;

    public function changeAppStateTo(EStates $state, string $id): bool
    {
        $reader = new AppReader();
        $app = $reader->getAppById($id);
        $app->setState($state->value);

        return $this->applications()->update($app) ? true : false;
    }

    public function updateApp(string $id, string $path): bool
    {
        $reader = new AppReader();
        $app = $reader->getAppById($id);
        $new = $this->createAppByConfigPath($path, false);

        if (!$app || !$new || ($app->compareVersionTo($new->getVersion()))) {
            return false;
        }

        $new->setState(EStates::Pending->value)->setId($app->getId());
        $this->applications()->update($new);

        return $this->installApp($new->getId());
    }

    public function updateAppInfo(IAppInfo $appInfo): void
    {
        $this->appInfo()->update($appInfo);
    }

    public function installApp(string $id): bool
    {
        $reader = new AppReader();
        $app = $reader->getAppById($id);
        $packageName = $app->getPackage();
        $composerPath = $this->getInstallPath();
        $this->requirePackage($packageName, $composerPath);
        $installed = true;

        if ($this->needCheckAfterInstall()) {
            if (file_exists($composerPath . '/composer.json')) {
                require($composerPath . '/vendor/autoload.php');
            }
            
            $resolver = $app->getResolver();
            $installed = class_exists($resolver);

            if ($installed) {
                $app->setState(EStates::Accepted->value);
                $this->applications()->update($app);
                $this->convertExtasPhpConfigs([
                    'command' => 'g',
                    '-p' => getenv('DF__SAVE_PATH') ?: 'runtime'
                ]);
                $this->installExtasPackages([
                    'command' => 'install',
                    '-t' => getenv('DF__TEMPLATE_PATH') ?: 'vendor/jeyroik/extas-foundation/resources',
                    '-s' => getenv('DF__SAVE_PATH') ?: 'runtime',
                    '-p' => getenv('EXTAS__APPLICATION_PATH') ?: getcwd()
                ]);
            }
        }

        return $installed;
    }

    public function createAppByConfigPath(string $path, bool $saveAfterCreate = true): ?IApplication
    {
        $config = file_get_contents($path);
        $decoded = json_decode($config, true);
        $decoded[IHasState::FIELD__STATE] = EStates::Pending->value;
        $app = new DeflouApplication($decoded);

        if ($saveAfterCreate) {
            $app = $this->applications()->create($app);
            $this->createInfo($app);
        }

        return $app;
    }

    public function needCheckAfterInstall(): bool
    {
        return $this->config[static::FIELD__INSTALL_CHECK] ?? true;
    }

    public function setInstallCheck(bool $need): static
    {
        $this->config[static::FIELD__INSTALL_CHECK] = $need;

        return $this;
    }

    public function installExtasPackages(array $settings, OutputInterface $output = null): void
    {
        $input = new ArrayInput($settings);
        $output = $output ?: new BufferedOutput(BufferedOutput::VERBOSITY_VERY_VERBOSE);
        
        $application = new ConsoleApplication();
        $application->add(new InstallCommand());
        $application->setDefaultCommand('install');
        $application->setAutoExit(false);
        $application->run($input, $output);
    }

    public function convertExtasPhpConfigs(array $settings, OutputInterface $output = null): void
    {
        $input = new ArrayInput($settings);
        $output = $output ?: new BufferedOutput(BufferedOutput::VERBOSITY_VERY_VERBOSE);
        
        $application = new ConsoleApplication();
        $application->add(new GenerateCommand());
        $application->setDefaultCommand('g');
        $application->setAutoExit(false);
        $application->run($input, $output);
    }

    protected function createInfo(IApplication $app): IAppInfo
    {
        $appInfo = new AppInfo([
            AppInfo::FIELD__APPLICATION_ID => $app->getId(),
            AppInfo::FIELD__VENDOR => $app->getVendor(),
            AppInfo::FIELD__CREATED_AT => time(),
            AppInfo::FIELD__INSTANCES_COUNT => 0,
            AppInfo::FIELD__TRIGGERS_COUNT => 0,
            AppInfo::FIELD__REQUESTS_COUNT => 0,
            AppInfo::FIELD__EXECUTIONS_COUNT => 0,
            AppInfo::FIELD__RATING => 0,
            AppInfo::FIELD__LAST_EXECUTED_AT => 0
        ]);

        return $this->appInfo()->create($appInfo);
    }

    protected function requirePackage(string $packageName, string $composerPath): void
    {
        $input = new ArrayInput([
            'command' => 'require',
            'packages' => [$packageName],
            '--working-dir' => $composerPath
        ]);
        
        $output = new BufferedOutput(BufferedOutput::VERBOSITY_VERY_VERBOSE);
        
        $application = new Application();
        $application->add(new RequireCommand());
        $application->setDefaultCommand('require');
        $application->setAutoExit(false);
        $application->run($input, $output);
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
