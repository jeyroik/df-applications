<?php
namespace deflou\interfaces\applications\options;

use extas\interfaces\IHasName;
use extas\interfaces\IItem;

interface IOptionItem extends IItem
{
    public const SUBJECT = 'deflou.application.option.item';

    public static function encryptOptions(IHaveOptions|IHasName &$item): void;
    public static function hashOptions(IHaveOptions|IHasName &$item): void;
    public static function decryptOptions(IHaveOptions|IHasName &$item = null): void;
}
