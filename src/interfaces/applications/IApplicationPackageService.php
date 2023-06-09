<?php
namespace deflou\interfaces\applications;

use extas\interfaces\IItem;
use deflou\components\applications\packages\EStates;

interface IApplicationPackageService extends IItem
{
    public const SUBJECT = 'deflou.application.package.service';

    public const FIELD__INSTALL_PATH = 'ip';
    public const FIELD__INSTALL_CHECK = 'true';

    /**
     * @param IApplicationPackage[]
     * 
     * @return array [[<package>, ...],[<package>, ...]] - [<installed packages>, <not installed packages>]
     */
    public function checkPackages(array $packages): array;

    /**
     * @param string $id
     * 
     * @return bool is package installed
     */
    public function installPackage(string $id): bool;

    /**
     * Get packages by state
     *
     * @param EState $state
     * @param array $vendorNames
     * 
     * @return IApplicationPackage[]
     */
    public function getPackagesByState(EStates $state, array $vendorNames = []): array;

    public function createPackageByConfigPath(string $path): ?IApplicationPackage;

    public function getPackageById(string $id, array $vendorNames = []): ?IApplicationPackage;

    /**
     * Get packages by vendor name
     *
     * @param array $names
     * 
     * @return IApplicationPackage[]
     */
    public function getPackagesByVendor(array $names): array;

    /**
     * Group packages by status
     *
     * @param IApplicationPackage[] $packages
     * @return array ['awaiting' => [...], 'accepted' => [...], 'published' => [...], 'declined' => [...]]
     */
    public function groupPackagesByState(array $packages): array;

    public function getInstallPath(): string;
    public function needCheckAfterInstall(): bool;

    public function setInstallCheck(bool $need): static;
}
