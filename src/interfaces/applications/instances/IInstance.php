<?php
namespace deflou\interfaces\applications\instances;

use deflou\interfaces\applications\IApplicationPackage;
use deflou\interfaces\applications\IHaveApplication;
use deflou\interfaces\applications\packages\avatars\IHaveAvatar;
use deflou\interfaces\applications\packages\events\IHaveEvents;
use deflou\interfaces\applications\packages\IHaveResolver;
use deflou\interfaces\applications\packages\operations\IHaveOperations;
use deflou\interfaces\applications\packages\options\IHaveOptions;
use deflou\interfaces\applications\packages\vendors\IHaveVendor;
use extas\interfaces\IHasClass;
use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IHasType;
use extas\interfaces\IHasVersion;
use extas\interfaces\IHaveUUID;
use extas\interfaces\IItem;

interface IInstance extends IItem, IHasName, IHasDescription, IHasClass, IHasType, IHaveUUID, IHasVersion,
    IHaveAvatar, IHaveVendor, IHaveOptions, IHaveEvents, IHaveOperations, IHaveApplication, IHaveResolver
{
    public const SUBJECT = 'df.application.instance';
}
