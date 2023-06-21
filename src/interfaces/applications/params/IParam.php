<?php
namespace deflou\interfaces\applications\params;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;

interface IParam extends IHasName, IHasDescription
{
    public const SUBJECT = 'deflou.application.param';
}
