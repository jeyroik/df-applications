<?php
namespace deflou\components\applications\packages\avatars;

use deflou\interfaces\applications\packages\avatars\IHaveAvatar;

/**
 * @property array $config
 */
trait THasAvatar
{
    public function getAvatar(): string
    {
        return $this->config[IHaveAvatar::FIELD__AVATAR] ?? '';
    }
}
