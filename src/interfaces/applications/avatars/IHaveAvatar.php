<?php
namespace deflou\interfaces\applications\avatars;

interface IHaveAvatar
{
    public const FIELD__AVATAR = 'avatar';

    public function getAvatar(): string;
}
