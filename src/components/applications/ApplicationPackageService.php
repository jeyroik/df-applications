<?php
namespace deflou\components\applications;

use Composer\Command\RequireCommand;
use Composer\Console\Application;
use extas\components\Item;
use extas\interfaces\IHasState;
use extas\interfaces\repositories\IRepository;
use deflou\components\applications\packages\EStates;
use deflou\interfaces\applications\IApplicationPackage;
use deflou\interfaces\applications\IApplicationPackageService;
use deflou\interfaces\applications\packages\IVendor;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * @method IRepository applicationPackages()
 */
class ApplicationPackageService extends Item implements IApplicationPackageService
{
    /**
     * @param IApplicationPackage[]
     * 
     * @return array [[<package>, ...],[<package>, ...]] - [<installed packages>, <not installed packages>]
     */
    public function checkPackages(array $packages): array
    {
        $composerPath = $this->getInstallPath();

        if (file_exists($composerPath . '/composer.json')) {
            require($composerPath . '/vendor/autoload.php');
        }

        $installed = [];
        $notInstalled = [];

        foreach ($packages as $package) {
            $resolver = $package->getResolver();
            if (class_exists($resolver)) {
                $installed[] = $package;
            } else {
                $notInstalled[] = $package;
            }
        }

        return [$installed, $notInstalled];
    }

    public function updatePackage(string $id, string $path): bool
    {
        /**
         * @var IApplicationPackage $package
         */
        $package = $this->applicationPackages()->one([
            IApplicationPackage::FIELD__ID => $id
        ]);

        $new = $this->createPackageByConfigPath($path, false);

        if (!$package || !$new || ($package->getVersion() == $new->getVersion())) {
            return false;
        }

        $new->setState(EStates::Pending->value)->setId($package->getId());
        $this->applicationPackages()->update($new);

        return $this->installPackage($new->getId());
    }

    public function installPackage(string $id): bool
    {
        /**
         * @var IApplicationPackage $package
         */
        $package = $this->applicationPackages()->one([
            IApplicationPackage::FIELD__ID => $id
        ]);

        $packageName = $package->getPackage();
        $composerPath = $this->getInstallPath();
        $this->requirePackage($packageName, $composerPath);
        $installed = true;

        if ($this->needCheckAfterInstall()) {
            if (file_exists($composerPath . '/composer.json')) {
                require($composerPath . '/vendor/autoload.php');
            }
            
            file_put_contents('/tmp/df.log', date('[Y-m-d H:i:s] ').$output->fetch()."\n", FILE_APPEND);
            $resolver = $package->getResolver();
            $installed = class_exists($resolver);

            if ($installed) {
                $package->setState(EStates::Accepted->value);
                $this->applicationPackages()->update($package);
            }
        }

        return $installed;
    }

    public function getPackagesByState(EStates $state, array $vendorNames = []): array
    {
        $query = [
            IApplicationPackage::FIELD__STATE => $state->value
        ];

        if (!empty($vendorNames)) {
            $query[IApplicationPackage::FIELD__VENDOR . '.' . IVendor::FIELD__NAME] = $vendorNames;
        }

        return $this->applicationPackages()->all($query);
    }

    public function createPackageByConfigPath(string $path, bool $saveAfterCreate = true): ?IApplicationPackage
    {
        $config = file_get_contents($path);
        $decoded = json_decode($config, true);
        $decoded[IHasState::FIELD__STATE] = EStates::Pending->value;
        $package = new ApplicationPackage($decoded);

        return $saveAfterCreate ? $this->applicationPackages()->create($package) : $package;
    }

    public function getPackageById(string $id, array $vendorNames = []): ?IApplicationPackage
    {
        $query = [
            IApplicationPackage::FIELD__ID => $id
        ];

        if (!empty($vendorNames)) {
            $query[IApplicationPackage::FIELD__VENDOR . '.' . IVendor::FIELD__NAME] = $vendorNames;
        }

        return $this->applicationPackages()->one($query);
    }

    public function getPackagesByVendor(array $names): array
    {
        return $this->applicationPackages()->all([
            IApplicationPackage::FIELD__VENDOR . '.' . IVendor::FIELD__NAME => $names
        ]);
    }

    /**
     * Group packages by states
     *
     * @param IApplicationPackage[] $packages
     * @return array
     */
    public function groupPackagesByState(array $packages): array
    {
        $result = [
            EStates::Pending->value =>[],
            EStates::Accepted->value => [],
            EStates::Published->value => [],
            EStates::Declined->value => [],
            EStates::Canceled->value => []
        ];

        foreach ($packages as $package) {
            if (EStates::tryFrom($package->getState())) {
                $result[$package->getState()][] = $package;
            }
        }

        return $result;
    }

    public function getInstallPath(): string
    {
        return $this->config[static::FIELD__INSTALL_PATH] ?? getcwd() . '/../runtime';
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
