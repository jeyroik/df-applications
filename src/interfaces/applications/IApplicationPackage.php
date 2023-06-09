<?php
namespace deflou\interfaces\applications;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IHasState;
use extas\interfaces\IHasType;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;
use deflou\interfaces\applications\packages\avatars\IHaveAvatar;
use deflou\interfaces\applications\packages\events\IHaveEvents;
use deflou\interfaces\applications\packages\operations\IHaveOperations;
use deflou\interfaces\applications\packages\options\IHaveOptions;
use deflou\interfaces\applications\packages\vendors\IHaveVendor;

interface IApplicationPackage extends IItem, IHaveUUID, IHasName, IHasDescription, IHasType, IHasState, 
    IHaveVendor,  IHaveEvents,  IHaveOperations, IHaveAvatar, IHaveOptions
{
    public const SUBJECT = 'deflou.appication.package';

    public const FIELD__PACKAGE = 'package';

    public function getPackage(): string;
}
