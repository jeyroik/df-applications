<?php
namespace deflou\interfaces\applications\packages\avatars;

interface IHaveAvatar
{
    public const FIELD__AVATAR = 'avatar';

    public function getAvatar(): string;
}
