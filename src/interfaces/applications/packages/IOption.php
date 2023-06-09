<?php
namespace deflou\interfaces\applications\packages;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IHasType;
use extas\interfaces\IItem;

interface IOption extends IItem, IHasName, IHasDescription, IHasType
{
    public const SUBJECT = 'deflou.application.package.option';

    public const FIELD__DEFAULT = 'default';
    public const FIELD__REQUIRED = 'required';
    public const FIELD__ENCODE = 'encode';
    public const FIELD__HASHING = 'hashing';

    public function getDefault(): mixed;
    public function getRequired(): bool;
    public function getEncode(): bool;
    public function getHashing(): bool;

    //syntax sugar
    public function isRequired(): bool;
    public function isNeedToEncode(): bool;
    public function isNeedToHash(): bool;
}
