<?php
namespace deflou\components\applications;

use deflou\interfaces\applications\IHaveInstallPath;

/**
 * @property array $config
 */
trait THasInstallPath
{
    public function getInstallPath(): string
    {
        return $this->config[IHaveInstallPath::FIELD__INSTALL_PATH] ?? getcwd() . '/../runtime';
    }
}
