<?php
namespace deflou\interfaces\applications;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IHasState;
use extas\interfaces\IHasType;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;
use extas\interfaces\IHasVersion;
use deflou\interfaces\applications\avatars\IHaveAvatar;
use deflou\interfaces\applications\events\IHaveEvents;
use deflou\interfaces\applications\operations\IHaveOperations;
use deflou\interfaces\applications\options\IHaveOptions;
use deflou\interfaces\applications\resolvers\IHaveResolver;
use deflou\interfaces\applications\vendors\IHaveVendor;

interface IApplication extends IItem, IHaveUUID, IHasName, IHasDescription, IHasType, IHasState, IHasVersion,
    IHaveVendor,  IHaveEvents,  IHaveOperations, IHaveAvatar, IHaveOptions, IHaveResolver
{
    public const SUBJECT = 'deflou.appication';

    public const FIELD__PACKAGE = 'package';

    public function getPackage(): string;
}
