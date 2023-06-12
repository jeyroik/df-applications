<?php
namespace deflou\components\applications;

use extas\components\Item;
use extas\interfaces\repositories\IRepository;
use deflou\components\applications\EStates;
use deflou\interfaces\applications\IApplication;
use deflou\interfaces\applications\IApplicationPackage;
use deflou\interfaces\applications\IAppReader;
use deflou\interfaces\applications\vendors\IVendor;

/**
 * @method IRepository applications()
 */
class AppReader extends Item implements IAppReader
{
    use THasInstallPath;

    /**
     * @param IApplication[]
     * 
     * @return array [[<app>, ...],[<app>, ...]] - [<installed apps>, <not installed apps>]
     */
    public function checkApps(array $apps): array
    {
        $composerPath = $this->getInstallPath();

        if (file_exists($composerPath . '/composer.json')) {
            require($composerPath . '/vendor/autoload.php');
        }

        $installed = [];
        $notInstalled = [];

        foreach ($apps as $app) {
            $resolver = $app->getResolver();
            if (class_exists($resolver)) {
                $installed[] = $app;
            } else {
                $notInstalled[] = $app;
            }
        }

        return [$installed, $notInstalled];
    }

    public function getAppsByState(EStates $state, array $vendorNames = []): array
    {
        $query = [
            IApplication::FIELD__STATE => $state->value
        ];

        if (!empty($vendorNames)) {
            $query[IApplication::FIELD__VENDOR . '.' . IVendor::FIELD__NAME] = $vendorNames;
        }

        return $this->applications()->all($query);
    }

    public function getAppById(string $id, array $vendorNames = []): ?IApplication
    {
        $query = [
            IApplication::FIELD__ID => $id
        ];

        if (!empty($vendorNames)) {
            $query[IApplication::FIELD__VENDOR . '.' . IVendor::FIELD__NAME] = $vendorNames;
        }

        return $this->applications()->one($query);
    }

    public function getAppsByVendor(array $names): array
    {
        return $this->applications()->all([
            IApplication::FIELD__VENDOR . '.' . IVendor::FIELD__NAME => $names
        ]);
    }

    /**
     * Group apps by states
     *
     * @param IApplicationPackage[] $apps
     * @return array
     */
    public function groupAppsByState(array $apps): array
    {
        $result = [
            EStates::Pending->value =>[],
            EStates::Accepted->value => [],
            EStates::Published->value => [],
            EStates::Declined->value => [],
            EStates::Canceled->value => []
        ];

        foreach ($apps as $app) {
            if (EStates::tryFrom($app->getState())) {
                $result[$app->getState()][] = $app;
            }
        }

        return $result;
    }

    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
