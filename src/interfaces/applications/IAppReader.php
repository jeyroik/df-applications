<?php
namespace deflou\interfaces\applications;

use extas\interfaces\IItem;
use deflou\components\applications\EStates;
use deflou\interfaces\applications\info\IAppInfo;

interface IAppReader extends IItem, IHaveInstallPath
{
    public const SUBJECT = 'deflou.application.reader';

    /**
     * @param IApplication[]
     * 
     * @return array [[<app>, ...],[<app>, ...]] - [<installed apps>, <not installed apps>]
     */
    public function checkApps(array $apps): array;

    /**
     * Get apps by state
     *
     * @param EState $state
     * @param array $vendorNames
     * 
     * @return IApplication[]
     */
    public function getAppsByState(EStates $state, array $vendorNames = []): array;

    public function getAppById(string $id, array $vendorNames = []): ?IApplication;

    public function getAppInfo(string $appId): ?IAppInfo;

    /**
     * Get apps by vendor name
     *
     * @param array $names
     * 
     * @return IApplication[]
     */
    public function getAppsByVendor(array $names): array;

    /**
     * Group apps by status
     *
     * @param IApplication[] $apps
     * @return array ['pending' => [...], 'accepted' => [...], 'canceled' => [...], 'declined' => [...]]
     */
    public function groupAppsByState(array $apps): array;
}
