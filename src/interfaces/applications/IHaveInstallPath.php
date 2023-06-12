<?php
namespace deflou\interfaces\applications;

interface IHaveInstallPath
{
    public const FIELD__INSTALL_PATH = 'ip';

    public function getInstallPath(): string;
}
