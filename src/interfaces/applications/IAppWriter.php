<?php
namespace deflou\interfaces\applications;

use extas\interfaces\IItem;
use deflou\components\applications\EStates;

interface IAppWriter extends IItem, IHaveInstallPath
{
    public const SUBJECT = 'deflou.application.writer';

    public const FIELD__INSTALL_CHECK = 'true';

    /**
     * @stage deflou.application.state.changed
     * @stage deflou.application.<application.name>.state.changed
     */
    public function changeAppStateTo(EStates $state, string $id): bool;

    /**
     * @param string $id
     * 
     * @return bool is app installed
     * 
     * @stage deflou.application.installed
     * @stage deflou.application.<application.name>.installed
     */
    public function installApp(string $id): bool;

    /**
     * @param string $id
     * @param string $path for the new structure
     * 
     * @return bool is app updated
     * 
     * @stage deflou.application.updated
     * @stage deflou.application.<application.name>.updated
     */
    public function updateApp(string $id, string $path): bool;

    /**
     * @stage deflou.application.created.by.config
     * @stage deflou.application.<application.name>.created.by.config
     */
    public function createAppByConfigPath(string $path, bool $saveAfterCreate = true): ?IApplication;

    public function needCheckAfterInstall(): bool;

    public function setInstallCheck(bool $need): static;
}
