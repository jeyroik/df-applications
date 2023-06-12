<?php
namespace deflou\components\applications\avatars;

use deflou\interfaces\applications\avatars\IHaveAvatar;

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
